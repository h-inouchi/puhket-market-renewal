<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PersonalSchedules Controller
 *
 * @property \App\Model\Table\PersonalSchedulesTable $PersonalSchedules
 */
class PersonalSchedulesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['LiveShowTitles', 'Places', 'Users', 'UnitMembers']
        ];
        $personalSchedules = $this->paginate($this->PersonalSchedules);

        $this->set(compact('personalSchedules'));
        $this->set('_serialize', ['personalSchedules']);
    }

    /**
     * View method
     *
     * @param string|null $id Personal Schedule id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $personalSchedule = $this->PersonalSchedules->get($id, [
            'contain' => ['LiveShowTitles', 'Places', 'Users', 'UnitMembers']
        ]);

        $this->set('personalSchedule', $personalSchedule);
        $this->set('_serialize', ['personalSchedule']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $personalSchedule = $this->PersonalSchedules->newEntity();
        if ($this->request->is('post')) {
            $personalSchedule = $this->PersonalSchedules->patchEntity($personalSchedule, $this->request->getData());
            if ($this->PersonalSchedules->save($personalSchedule)) {
                $this->Flash->success(__('The personal schedule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The personal schedule could not be saved. Please, try again.'));
        }
        $liveShowTitles = $this->PersonalSchedules->LiveShowTitles->find('list', ['limit' => 200]);
        $places = $this->PersonalSchedules->Places->find('list', ['limit' => 200]);
        $users = $this->PersonalSchedules->Users->find('list', ['limit' => 200]);
        $unitMembers = $this->PersonalSchedules->UnitMembers->find('list', ['limit' => 200]);
        $this->set(compact('personalSchedule', 'liveShowTitles', 'places', 'users', 'unitMembers'));
        $this->set('_serialize', ['personalSchedule']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Personal Schedule id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $personalSchedule = $this->PersonalSchedules->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $personalSchedule = $this->PersonalSchedules->patchEntity($personalSchedule, $this->request->getData());
            if ($this->PersonalSchedules->save($personalSchedule)) {
                $this->Flash->success(__('The personal schedule has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The personal schedule could not be saved. Please, try again.'));
        }
        $liveShowTitles = $this->PersonalSchedules->LiveShowTitles->find('list', ['limit' => 200]);
        $places = $this->PersonalSchedules->Places->find('list', ['limit' => 200]);
        $users = $this->PersonalSchedules->Users->find('list', ['limit' => 200]);
        $unitMembers = $this->PersonalSchedules->UnitMembers->find('list', ['limit' => 200]);
        $this->set(compact('personalSchedule', 'liveShowTitles', 'places', 'users', 'unitMembers'));
        $this->set('_serialize', ['personalSchedule']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Personal Schedule id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $personalSchedule = $this->PersonalSchedules->get($id);
        if ($this->PersonalSchedules->delete($personalSchedule)) {
            $this->Flash->success(__('The personal schedule has been deleted.'));
        } else {
            $this->Flash->error(__('The personal schedule could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
