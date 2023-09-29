<?php
declare(strict_types=1);

namespace App\Services;

use App\Model\Entity\Branch;
use App\Model\Entity\Repository;
use App\Model\Table\BranchesTable;
use App\Model\Table\RepositoriesTable;
use Cake\Core\Configure;
use Cake\Http\Client as CakeClient;
use Cake\Log\Log;
use Cake\ORM\Locator\LocatorAwareTrait;
use Github\Api\Repo;
use Github\AuthMethod;
use Github\Client as GithubClient;

class RepositorySync {
    use LocatorAwareTrait;

    private RepositoriesTable $Repositories;
    private BranchesTable $Branches;
    private Repo $repoService;

    public function __construct()
    {
        $this->Repositories = $this->getTableLocator()->get('Repositories');
        $this->Branches = $this->getTableLocator()->get('Branches');

        $client = GithubClient::createWithHttpClient(new CakeClient());
        $apiKey = Configure::read('API.github');
        $client->authenticate('lordsimal', $apiKey, AuthMethod::CLIENT_ID);
        $this->repoService = $client->api('repo');
    }

    public function sync(): void
    {
        $result = $this->repoService->org('cakephp');

        if (!empty($result)) {
            $touchedRepoIds = [];

            foreach ($result as $repo) {

                $data = [
                    'name' => $repo['name'],
                    'url' => $repo['html_url'],
                    'forks' => $repo['forks_count'],
                    'open_issues' => $repo['open_issues_count'],
                    'external_ident' => $repo['id']
                ];
                $touchedRepoIds[] = $data['external_ident'];

                $repoEntity = $this->Repositories->find()
                    ->where(['external_ident' => $data['external_ident']])
                    ->first();

                if (!$repoEntity instanceof Repository) {
                    $repoEntity = $this->Repositories->newEmptyEntity();
                }

                $repoEntity = $this->Repositories->patchEntity($repoEntity, $data);

                if ($this->Repositories->save($repoEntity)) {
                    $this->syncBranches($repoEntity);
                } else {
                    Log::warning('Cloud not save repo entity');
                    Log::warning(print_r($repoEntity, true));
                }

            }

            if (!empty($touchedRepoIds)) {
                $dbEntries = $this->Repositories->find(
                    'list',
                    ['valueField' => 'external_ident']
                )->all()->toArray();
                $diff = array_diff($dbEntries, $touchedRepoIds);
                if ($diff) {
                    foreach($diff as $itemId => $itemExternalId) {
                        $repoEntity = $this->Repositories->get($itemId);
                        Log::info(sprintf('Deleted Repository: %s', $repoEntity->name));
                        $this->Repositories->delete($repoEntity);
                    }
                }
            }

        }
    }

    private function syncBranches(Repository $repository): void
    {
        $branches = $this->repoService->branches('cakephp', $repository->name);
        if ($branches):
            // Add $touchedBranchesIds variable
            $touchedBranches = [];

            foreach ($branches as $branch):
                $touchedBranches[] = $repository->id . '-' . $branch['name'];

                $data = [
                    'name' => $branch['name'],
                    'repository_id' => $repository->id,
                ];

                $branchEntity = $this->Branches->find()
                    ->where([
                        'name' => $data['name'],
                        'repository_id' => $repository->id
                    ])
                    ->first();

                // Update or create depending if the entity is already in DB
                if (!$branchEntity instanceof Branch) {
                    $branchEntity = $this->Branches->newEmptyEntity();
                }

                $branchEntity = $this->Branches->patchEntity($branchEntity, $data);

                if ($this->Branches->save($branchEntity)) {
                    // Yay!
                } else {
                    Log::warning('Could not save branch entity!');
                    Log::warning(print_r($branchEntity, true));
                }

            endforeach;

            // Check touched_ids with ids currently in db
            if (!empty($touchedBranches)) :
                $dbEntries = $this->Branches->find(
                    'list',
                    [
                        'valueField' => function (Branch $branch) {
                            return $branch->repository_id . '-' . $branch->name;
                        }
                    ]
                )
                    ->where(['Branches.repository_id' => $repository->id])
                    ->toArray();
                $diff = array_diff($dbEntries, $touchedBranches);
                if (!empty($diff)) :
                    foreach ($diff as $itemId => $itemValue) :
                        $branchEntity = $this->Branches->get($itemId);
                        Log::info(sprintf('Deleted Branch: %s', $branchEntity->name));
                        $this->Branches->delete($branchEntity);
                    endforeach;
                endif;
            endif;
        endif;
    }
}
