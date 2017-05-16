<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
/**
 * PersonalSchedules Controller
 *
 * @property \App\Model\Table\PersonalSchedulesTable $PersonalSchedules
 */
class PersonalSchedulesController extends AppController
{
    public $components = [
        'ScheduleManager',
    ];
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->deny([
            'index',
            'add',
            'delete',
            'edit',
        ]);
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        // 日付の指定がある場合
        $date = Hash::get($this->request->query, 'date');
        $userId = $this->Auth->user('id');
        $searchDate;
        if ($date) {
            $searchDate = date('Y/m/d', strtotime($date));
        } else {
            $searchDate = date('Y/m/d');
        }
        $personalSchedules = $this->PersonalSchedules->find('all',
            [
                'order' => [
                    'schedule_date' => 'asc',
                    'start_time' => 'asc',
                ],
                'conditions' => [
                    'schedule_date >=' => $searchDate,
                    'PersonalSchedules.user_id' => $userId,
                ],
            ]
        );
        $weekday = ['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'];
        foreach ($personalSchedules as $personalSchedule) {
            $week = $weekday[date('w', strtotime($personalSchedule->schedule_date))];
            $personalSchedule->schedule_date_and_week =
                date('Y/m/d ', strtotime( $personalSchedule->schedule_date ) ) . $week;
        }
        $this->set('personalSchedules', $personalSchedules);
        $user = $this->PersonalSchedules->Users->get($userId);

        if (!$user) {
            //変なurlだったら取り敢えずトップに。
            $this->redirect(
                    [
                    'action' => 'index'
                    ]
            );
        }
        $this->set('user', $user);
        $this->set('title_for_layout', $user->unit_name . '　個人予定一覧');

        /////// カレンダー用 ////////////

        $part_time_job_dates = [];
        $live_schedule_dates = [];
        $schedule_dates = [];
        unset($personalSchedule);

        foreach ($personalSchedules as $personalSchedule) {
            if (strpos($personalSchedule->schedule_title, 'ライブ') !== false) {
                //ライブの場合
                $live_schedule_dates[] = $personalSchedule->schedule_date;
            } elseif (strpos($personalSchedule->schedule_title, 'バイト') !== false) {
                //バイトの場合
                $part_time_job_dates[] = $personalSchedule->schedule_date;
            } else {
                //それ以外
                $schedule_dates[] = $personalSchedule->schedule_date;
            }
        }
        $schedules = $this->ScheduleManager->getNationalHolidayFromDate($date);
        $y = Hash::get($schedules, 'y');
        $m = Hash::get($schedules, 'm');
        $national_holiday = Hash::get($schedules, 'national_holiday');

        $this->set([
            'y' => $y,
            'm' => $m,
            'national_holiday' => $national_holiday,
            'schedule_dates' => $schedule_dates,
            'part_time_job_dates' => $part_time_job_dates,
            'live_schedule_dates' => $live_schedule_dates,
        ]);
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
            $personalSchedule->user_id = $this->Auth->user('id');
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
