<?php
declare(strict_types=1);

namespace App\Controller;

use App\Services\RepositorySync;
use Github\Api\Repo;

/**
 * Repositories Controller
 *
 * @property \App\Model\Table\RepositoriesTable $Repositories
 * @method \App\Model\Entity\Repository[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RepositoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $repositories = $this->paginate($this->Repositories);

        $this->set(compact('repositories'));
    }

    /**
     * View method
     *
     * @param string|null $id Repository id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $repository = $this->Repositories->get($id, [
            'contain' => ['Branches'],
        ]);

        $this->set(compact('repository'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $repository = $this->Repositories->newEmptyEntity();
        if ($this->request->is('post')) {
            $repository = $this->Repositories->patchEntity($repository, $this->request->getData());
            if ($this->Repositories->save($repository)) {
                $this->Flash->success(__('The repository has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The repository could not be saved. Please, try again.'));
        }
        $this->set(compact('repository'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Repository id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $repository = $this->Repositories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $repository = $this->Repositories->patchEntity($repository, $this->request->getData());
            if ($this->Repositories->save($repository)) {
                $this->Flash->success(__('The repository has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The repository could not be saved. Please, try again.'));
        }
        $this->set(compact('repository'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Repository id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $repository = $this->Repositories->get($id);
        if ($this->Repositories->delete($repository)) {
            $this->Flash->success(__('The repository has been deleted.'));
        } else {
            $this->Flash->error(__('The repository could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function sync(RepositorySync $service): void
    {
        $service->sync();
    }
}
