<?php
declare(strict_types=1);

namespace App\Services;

use Cake\Core\Configure;
use Cake\Http\Client as CakeClient;
use Github\Api\Repo;
use Github\AuthMethod;
use Github\Client as GithubClient;

class RepositoryClient
{
    private Repo $repoService;

    /**
     * Initialize Github SDK Client
     */
    public function __construct()
    {
        $client = GithubClient::createWithHttpClient(new CakeClient());
        $apiKey = Configure::read('API.github');
        $client->authenticate('lordsimal', $apiKey, AuthMethod::CLIENT_ID);
        /** @phpstan-ignore-next-line  */
        $this->repoService = $client->api('repo');
    }

    /**
     * @param string $organization the name of the organization
     * @param array $params The result
     * @return array list of organization repositories
     */
    public function org($organization, array $params = []): array
    {
        return $this->repoService->org($organization, $params);
    }

    /**
     * @param string $username the username
     * @param string $repository the name of the repository
     * @param string $branch the name of the branch
     * @param array $parameters parameters for the query string
     * @return array list of the repository branches
     */
    public function branches($username, $repository, $branch = null, array $parameters = []): array
    {
        return $this->repoService->branches($username, $repository, $branch, $parameters);
    }
}
