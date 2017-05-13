<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * IkuyoComments Controller
 *
 * @property \App\Model\Table\IkuyoCommentsTable $IkuyoComments
 */
class IkuyoCommentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ComedyLiveShows', 'LiveShowTitles']
        ];
        $ikuyoComments = $this->paginate($this->IkuyoComments);

        $this->set(compact('ikuyoComments'));
        $this->set('_serialize', ['ikuyoComments']);
    }

    /**
     * View method
     *
     * @param string|null $id Ikuyo Comment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $ikuyoComment = $this->IkuyoComments->get($id, [
            'contain' => ['ComedyLiveShows', 'LiveShowTitles']
        ]);

        $this->set('ikuyoComment', $ikuyoComment);
        $this->set('_serialize', ['ikuyoComment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $ikuyoComment = $this->IkuyoComments->newEntity();
        if ($this->request->is('post')) {
            $ikuyoComment = $this->IkuyoComments->patchEntity($ikuyoComment, $this->request->getData());
            if ($this->IkuyoComments->save($ikuyoComment)) {
                $this->Flash->success(__('The ikuyo comment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ikuyo comment could not be saved. Please, try again.'));
        }
        $comedyLiveShows = $this->IkuyoComments->ComedyLiveShows->find('list', ['limit' => 200]);
        $liveShowTitles = $this->IkuyoComments->LiveShowTitles->find('list', ['limit' => 200]);
        $this->set(compact('ikuyoComment', 'comedyLiveShows', 'liveShowTitles'));
        $this->set('_serialize', ['ikuyoComment']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Ikuyo Comment id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ikuyoComment = $this->IkuyoComments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ikuyoComment = $this->IkuyoComments->patchEntity($ikuyoComment, $this->request->getData());
            if ($this->IkuyoComments->save($ikuyoComment)) {
                $this->Flash->success(__('The ikuyo comment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The ikuyo comment could not be saved. Please, try again.'));
        }
        $comedyLiveShows = $this->IkuyoComments->ComedyLiveShows->find('list', ['limit' => 200]);
        $liveShowTitles = $this->IkuyoComments->LiveShowTitles->find('list', ['limit' => 200]);
        $this->set(compact('ikuyoComment', 'comedyLiveShows', 'liveShowTitles'));
        $this->set('_serialize', ['ikuyoComment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ikuyo Comment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ikuyoComment = $this->IkuyoComments->get($id);
        if ($this->IkuyoComments->delete($ikuyoComment)) {
            $this->Flash->success(__('The ikuyo comment has been deleted.'));
        } else {
            $this->Flash->error(__('The ikuyo comment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
