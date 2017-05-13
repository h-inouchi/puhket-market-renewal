<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Users;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
/**
 * ComedyLiveShows Controller
 *
 * @property \App\Model\Table\ComedyLiveShowsTable $ComedyLiveShows
 */
class ComedyLiveShowsController extends AppController
{
	public $components = [
		'ScheduleManager',
	];
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
		// 日付の指定がある場合
		$date = Hash::get($this->request->query, 'date');
		$userId = Hash::get($this->request->query, 'userId');
		if (!$userId) {
			$userId = Hash::get($this->request->params, 'userId', 1);
		}
		$searchDate;
		if ($date) {
			$searchDate = date('Y/m/d', strtotime($date));
		} else {
			$searchDate = date('Y/m/d');
		}
		$comedy_live_shows_query = $this->ComedyLiveShows->find('all',
			[
				'contain' => ['LiveShowTitles', 'Places', 'Users'],
				'order' => [
					'live_show_date' => 'asc',
					'start' => 'asc',
				],
				'conditions' => [
					'live_show_date >=' => $searchDate,
					'ComedyLiveShows.user_id' => $userId,
				],
			]
		);
		$comedy_live_shows = $comedy_live_shows_query->all();
		$weekday = ['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'];
		foreach ($comedy_live_shows as $key => $comedy_live_show) {
			$week = $weekday[date('w', strtotime($comedy_live_show->live_show_date))];
			$comedy_live_show->live_show_date_week =
				date('Y/m/d ', strtotime( $comedy_live_show['live_show_date'] ) ) . $week;
		}
		$this->set('comedy_live_shows', $comedy_live_shows);

		$users = TableRegistry::get('Users');

		//unit_nameはライブ出演予定なくても取得するから別途select する
		$query = $users->find('all',
			[
				'conditions' => [
					'id' => $userId,
				],
			]
		);
		$user = $query->first();

		if (!$user) {
			//変なurlだったら取り敢えずトップに。
			$this->redirect(
				[
					'action' => 'index'
				]
			);
		}
		$this->set('user', $user);
		$this->set('title_for_layout', 'ライブ一覧 プーケットマーケット');

		/////// カレンダー用 ////////////
		$schedule_dates = Hash::extract($comedy_live_shows->toArray(), '{n}.ComedyLiveShows.live_show_date');
		$schedules = $this->ScheduleManager->getNationalHolidayFromDate($date);
		$y = Hash::get($schedules, 'y');
		$m = Hash::get($schedules, 'm');
		$national_holiday = Hash::get($schedules, 'national_holiday');

		/////// mover ////////////
		$mover =
		 [
            "url" => "/",
            "image" => "/img/w784_h297_senzai_syasin.jpg",
        ];

        $movers[] = $mover;
        $movers[] = $mover;
        $movers[] = $mover;
        $movers[] = $mover;
        $movers[] = $mover;
        $movers[] = $mover;
        $movers[] = $mover;
        $movers[] = $mover;
        $movers[] = $mover;
        $movers[] = $mover;
        $movers[] = $mover;
        $movers[] = $mover;

		$this->set([
			'movers' => $movers,
			'y' => $y,
			'm' => $m,
			'national_holiday' => $national_holiday,
			'schedule_dates' => $schedule_dates,
		]);
    }

    /**
     * View method
     *
     * @param string|null $id Comedy Live Show id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $comedyLiveShow = $this->ComedyLiveShows->get($id, [
            'contain' => ['LiveShowTitles', 'Places', 'Users', 'IkuyoComments']
        ]);

        $this->set('comedyLiveShow', $comedyLiveShow);
        $this->set('_serialize', ['comedyLiveShow']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $comedyLiveShow = $this->ComedyLiveShows->newEntity();
        if ($this->request->is('post')) {
            $comedyLiveShow = $this->ComedyLiveShows->patchEntity($comedyLiveShow, $this->request->getData());
            if ($this->ComedyLiveShows->save($comedyLiveShow)) {
                $this->Flash->success(__('The comedy live show has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The comedy live show could not be saved. Please, try again.'));
        }
        $liveShowTitles = $this->ComedyLiveShows->LiveShowTitles->find('list', ['limit' => 200]);
        $places = $this->ComedyLiveShows->Places->find('list', ['limit' => 200]);
        $users = $this->ComedyLiveShows->Users->find('list', ['limit' => 200]);
        $this->set(compact('comedyLiveShow', 'liveShowTitles', 'places', 'users'));
        $this->set('_serialize', ['comedyLiveShow']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Comedy Live Show id.
     * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comedyLiveShow = $this->ComedyLiveShows->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $comedyLiveShow = $this->ComedyLiveShows->patchEntity($comedyLiveShow, $this->request->getData());
            if ($this->ComedyLiveShows->save($comedyLiveShow)) {
                $this->Flash->success(__('The comedy live show has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The comedy live show could not be saved. Please, try again.'));
        }
        $liveShowTitles = $this->ComedyLiveShows->LiveShowTitles->find('list', ['limit' => 200]);
        $places = $this->ComedyLiveShows->Places->find('list', ['limit' => 200]);
        $users = $this->ComedyLiveShows->Users->find('list', ['limit' => 200]);
        $this->set(compact('comedyLiveShow', 'liveShowTitles', 'places', 'users'));
        $this->set('_serialize', ['comedyLiveShow']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Comedy Live Show id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comedyLiveShow = $this->ComedyLiveShows->get($id);
        if ($this->ComedyLiveShows->delete($comedyLiveShow)) {
            $this->Flash->success(__('The comedy live show has been deleted.'));
        } else {
            $this->Flash->error(__('The comedy live show could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
