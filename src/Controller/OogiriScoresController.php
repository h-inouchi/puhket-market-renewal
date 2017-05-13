<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * OogiriScores Controller
 *
 * @property \App\Model\Table\OogiriScoresTable $OogiriScores
 */
class OogiriScoresController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $oogiriScores = $this->paginate($this->OogiriScores);

        $this->set(compact('oogiriScores'));
        $this->set('_serialize', ['oogiriScores']);
    }

    /**
     * View method
     *
     * @param string|null $id Oogiri Score id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $oogiriScore = $this->OogiriScores->get($id, [
            'contain' => []
        ]);

        $this->set('oogiriScore', $oogiriScore);
        $this->set('_serialize', ['oogiriScore']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $oogiriScore = $this->OogiriScores->newEntity();
        if ($this->request->is('post')) {
            $oogiriScore = $this->OogiriScores->patchEntity($oogiriScore, $this->request->getData());
            if ($this->OogiriScores->save($oogiriScore)) {
                $this->Flash->success(__('The oogiri score has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The oogiri score could not be saved. Please, try again.'));
        }
        $this->set(compact('oogiriScore'));
        $this->set('_serialize', ['oogiriScore']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Oogiri Score id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $oogiriScore = $this->OogiriScores->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $oogiriScore = $this->OogiriScores->patchEntity($oogiriScore, $this->request->getData());
            if ($this->OogiriScores->save($oogiriScore)) {
                $this->Flash->success(__('The oogiri score has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The oogiri score could not be saved. Please, try again.'));
        }
        $this->set(compact('oogiriScore'));
        $this->set('_serialize', ['oogiriScore']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Oogiri Score id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $oogiriScore = $this->OogiriScores->get($id);
        if ($this->OogiriScores->delete($oogiriScore)) {
            $this->Flash->success(__('The oogiri score has been deleted.'));
        } else {
            $this->Flash->error(__('The oogiri score could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
