<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Branches Controller
 *
 * @property \App\Model\Table\BranchesTable $Branches
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BranchesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Repositories'],
        ];
        $branches = $this->paginate($this->Branches);

        $this->set(compact('branches'));
    }

    /**
     * View method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $branch = $this->Branches->get($id, contain: ['Repositories']);

        $this->set(compact('branch'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $branch = $this->Branches->newEmptyEntity();
        if ($this->request->is('post')) {
            $branch = $this->Branches->patchEntity($branch, $this->request->getData());
            if ($this->Branches->save($branch)) {
                $this->Flash->success(__('The branch has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The branch could not be saved. Please, try again.'));
        }
        $repositories = $this->Branches->Repositories->find('list', ['limit' => 200])->all();
        $this->set(compact('branch', 'repositories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $branch = $this->Branches->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $branch = $this->Branches->patchEntity($branch, $this->request->getData());
            if ($this->Branches->save($branch)) {
                $this->Flash->success(__('The branch has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The branch could not be saved. Please, try again.'));
        }
        $repositories = $this->Branches->Repositories->find('list', ['limit' => 200])->all();
        $this->set(compact('branch', 'repositories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Branch id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $branch = $this->Branches->get($id);
        if ($this->Branches->delete($branch)) {
            $this->Flash->success(__('The branch has been deleted.'));
        } else {
            $this->Flash->error(__('The branch could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
