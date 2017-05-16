<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
/**
 * LiveShowTitles Controller
 *
 * @property \App\Model\Table\LiveShowTitlesTable $LiveShowTitles
 */
class LiveShowTitlesController extends AppController
{
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->deny(
            [
                'index',
                'add',
                'edit',
                'delete',
            ]
        );
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $liveShowTitles = $this->paginate($this->LiveShowTitles);

        $this->set(compact('liveShowTitles'));
        $this->set('_serialize', ['liveShowTitles']);
    }

    /**
     * View method
     *
     * @param string|null $id Live Show Title id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $liveShowTitle = $this->LiveShowTitles->get($id, [
            'contain' => []
        ]);
        $this->set('liveShowTitle', $liveShowTitle);
        $this->set('title_for_layout', 'ライブ詳細：'.$liveShowTitle['LiveShowTitle']['title']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $liveShowTitle = $this->LiveShowTitles->newEntity();
        if ($this->request->is('post')) {
            $liveShowTitle = $this->LiveShowTitles->patchEntity($liveShowTitle, $this->request->getData());
            if ($this->LiveShowTitles->save($liveShowTitle)) {
                $this->Flash->success(__('The live show title has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The live show title could not be saved. Please, try again.'));
        }
        $users = $this->LiveShowTitles->Users->find('list', ['limit' => 200]);
        $this->set(compact('liveShowTitle', 'users'));
        $this->set('_serialize', ['liveShowTitle']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Live Show Title id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $liveShowTitle = $this->LiveShowTitles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $liveShowTitle = $this->LiveShowTitles->patchEntity($liveShowTitle, $this->request->getData());
            if ($this->LiveShowTitles->save($liveShowTitle)) {
                $this->Flash->success(__('The live show title has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The live show title could not be saved. Please, try again.'));
        }
        $users = $this->LiveShowTitles->Users->find('list', ['limit' => 200]);
        $this->set(compact('liveShowTitle', 'users'));
        $this->set('_serialize', ['liveShowTitle']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Live Show Title id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $liveShowTitle = $this->LiveShowTitles->get($id);
        if ($this->LiveShowTitles->delete($liveShowTitle)) {
            $this->Flash->success(__('The live show title has been deleted.'));
        } else {
            $this->Flash->error(__('The live show title could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
