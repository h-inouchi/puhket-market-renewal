<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Todouhukens Controller
 *
 * @property \App\Model\Table\TodouhukensTable $Todouhukens
 */
class TodouhukensController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $todouhukens = $this->paginate($this->Todouhukens);

        $this->set(compact('todouhukens'));
        $this->set('_serialize', ['todouhukens']);
    }

    /**
     * View method
     *
     * @param string|null $id Todouhuken id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $todouhuken = $this->Todouhukens->get($id, [
            'contain' => []
        ]);

        $this->set('todouhuken', $todouhuken);
        $this->set('_serialize', ['todouhuken']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $todouhuken = $this->Todouhukens->newEntity();
        if ($this->request->is('post')) {
            $todouhuken = $this->Todouhukens->patchEntity($todouhuken, $this->request->getData());
            if ($this->Todouhukens->save($todouhuken)) {
                $this->Flash->success(__('The todouhuken has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The todouhuken could not be saved. Please, try again.'));
        }
        $this->set(compact('todouhuken'));
        $this->set('_serialize', ['todouhuken']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Todouhuken id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $todouhuken = $this->Todouhukens->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $todouhuken = $this->Todouhukens->patchEntity($todouhuken, $this->request->getData());
            if ($this->Todouhukens->save($todouhuken)) {
                $this->Flash->success(__('The todouhuken has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The todouhuken could not be saved. Please, try again.'));
        }
        $this->set(compact('todouhuken'));
        $this->set('_serialize', ['todouhuken']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Todouhuken id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $todouhuken = $this->Todouhukens->get($id);
        if ($this->Todouhukens->delete($todouhuken)) {
            $this->Flash->success(__('The todouhuken has been deleted.'));
        } else {
            $this->Flash->error(__('The todouhuken could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
