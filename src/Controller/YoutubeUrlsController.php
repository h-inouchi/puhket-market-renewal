<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * YoutubeUrls Controller
 *
 * @property \App\Model\Table\YoutubeUrlsTable $YoutubeUrls
 */
class YoutubeUrlsController extends AppController
{

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
        $youtubeUrls = $this->paginate($this->YoutubeUrls);

        $this->set(compact('youtubeUrls'));
        $this->set('_serialize', ['youtubeUrls']);
    }

    /**
     * View method
     *
     * @param string|null $id Youtube Url id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $youtubeUrl = $this->YoutubeUrls->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('youtubeUrl', $youtubeUrl);
        $this->set('_serialize', ['youtubeUrl']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $youtubeUrl = $this->YoutubeUrls->newEntity();
        if ($this->request->is('post')) {
            $youtubeUrl = $this->YoutubeUrls->patchEntity($youtubeUrl, $this->request->getData());
            if ($this->YoutubeUrls->save($youtubeUrl)) {
                $this->Flash->success(__('The youtube url has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The youtube url could not be saved. Please, try again.'));
        }
        $users = $this->YoutubeUrls->Users->find('list', ['limit' => 200]);
        $this->set(compact('youtubeUrl', 'users'));
        $this->set('_serialize', ['youtubeUrl']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Youtube Url id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $youtubeUrl = $this->YoutubeUrls->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $youtubeUrl = $this->YoutubeUrls->patchEntity($youtubeUrl, $this->request->getData());
            if ($this->YoutubeUrls->save($youtubeUrl)) {
                $this->Flash->success(__('The youtube url has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The youtube url could not be saved. Please, try again.'));
        }
        $users = $this->YoutubeUrls->Users->find('list', ['limit' => 200]);
        $this->set(compact('youtubeUrl', 'users'));
        $this->set('_serialize', ['youtubeUrl']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Youtube Url id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $youtubeUrl = $this->YoutubeUrls->get($id);
        if ($this->YoutubeUrls->delete($youtubeUrl)) {
            $this->Flash->success(__('The youtube url has been deleted.'));
        } else {
            $this->Flash->error(__('The youtube url could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
