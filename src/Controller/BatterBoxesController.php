<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * BatterBoxes Controller
 *
 * @property \App\Model\Table\BatterBoxesTable $BatterBoxes
 */
class BatterBoxesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $batterBoxes = $this->paginate($this->BatterBoxes);

        $this->set(compact('batterBoxes'));
        $this->set('_serialize', ['batterBoxes']);
    }

    /**
     * View method
     *
     * @param string|null $id Batter Box id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $batterBox = $this->BatterBoxes->get($id, [
            'contain' => []
        ]);

        $this->set('batterBox', $batterBox);
        $this->set('_serialize', ['batterBox']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $batterBox = $this->BatterBoxes->newEntity();
        if ($this->request->is('post')) {
            $batterBox = $this->BatterBoxes->patchEntity($batterBox, $this->request->getData());
            if ($this->BatterBoxes->save($batterBox)) {
                $this->Flash->success(__('The batter box has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The batter box could not be saved. Please, try again.'));
        }
        $this->set(compact('batterBox'));
        $this->set('_serialize', ['batterBox']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Batter Box id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $batterBox = $this->BatterBoxes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $batterBox = $this->BatterBoxes->patchEntity($batterBox, $this->request->getData());
            if ($this->BatterBoxes->save($batterBox)) {
                $this->Flash->success(__('The batter box has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The batter box could not be saved. Please, try again.'));
        }
        $this->set(compact('batterBox'));
        $this->set('_serialize', ['batterBox']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Batter Box id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $batterBox = $this->BatterBoxes->get($id);
        if ($this->BatterBoxes->delete($batterBox)) {
            $this->Flash->success(__('The batter box has been deleted.'));
        } else {
            $this->Flash->error(__('The batter box could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
