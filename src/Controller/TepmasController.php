<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tepmas Controller
 *
 * @property \App\Model\Table\TepmasTable $Tepmas
 */
class TepmasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $tepmas = $this->paginate($this->Tepmas);

        $this->set(compact('tepmas'));
        $this->set('_serialize', ['tepmas']);
    }

    /**
     * View method
     *
     * @param string|null $id Tepma id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tepma = $this->Tepmas->get($id, [
            'contain' => []
        ]);

        $this->set('tepma', $tepma);
        $this->set('_serialize', ['tepma']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tepma = $this->Tepmas->newEntity();
        if ($this->request->is('post')) {
            $tepma = $this->Tepmas->patchEntity($tepma, $this->request->getData());
            if ($this->Tepmas->save($tepma)) {
                $this->Flash->success(__('The tepma has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tepma could not be saved. Please, try again.'));
        }
        $this->set(compact('tepma'));
        $this->set('_serialize', ['tepma']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tepma id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tepma = $this->Tepmas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tepma = $this->Tepmas->patchEntity($tepma, $this->request->getData());
            if ($this->Tepmas->save($tepma)) {
                $this->Flash->success(__('The tepma has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tepma could not be saved. Please, try again.'));
        }
        $this->set(compact('tepma'));
        $this->set('_serialize', ['tepma']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tepma id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tepma = $this->Tepmas->get($id);
        if ($this->Tepmas->delete($tepma)) {
            $this->Flash->success(__('The tepma has been deleted.'));
        } else {
            $this->Flash->error(__('The tepma could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
