<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
/**
 * IkuyoComments Controller
 *
 * @property \App\Model\Table\IkuyoCommentsTable $IkuyoComments
 */
class IkuyoCommentsController extends AppController
{
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->deny(
			[
				'index',
			]
		);
	}
	public function view($id = null) {
		$this->set('title_for_layout', '予約しました！');
		$ikuyoComment = $this->IkuyoComments->get($id, [
			'contain' => ['ComedyLiveShows','LiveShowTitles']
		]);

		$this->set('ikuyoComment', $ikuyoComment);

		$users = TableRegistry::get('Users');
		//unit_nameはライブ出演予定なくても取得するから別途select する
		$query = $users->find('all',
			[
				'conditions' => [
					'id' => $ikuyoComment->comedy_live_show->user_id,
				],
			]
		);
		$user = $query->first();

		$this->set('user', $user);
	}

	public function index() {
		$ikuyo_comments = $this->IkuyoComments->find('all',
			[
				'contain' => ['ComedyLiveShows','LiveShowTitles'],
				'order' => [
					'live_show_date' => 'asc',
					'start' => 'asc',
				],
				'conditions' => [
					'live_show_date >=' => date('Y/m/d'),
					'ComedyLiveShows.user_id' => $this->Auth->user('id'),
				],
			]
		);

		$weekday = ['(日)', '(月)', '(火)', '(水)', '(木)', '(金)', '(土)'];
		foreach ($ikuyo_comments as $ikuyo_comment) {
			$week = $weekday[date('w', strtotime($ikuyo_comment->comedy_live_show->live_show_date))];
			$ikuyo_comment->comedy_live_show->live_show_date =
				date('Y/m/d ', strtotime( $ikuyo_comment->comedy_live_show->live_show_date ) ) . $week;
		}

		$this->set('ikuyo_comments', $ikuyo_comments);
		$this->set('title_for_layout', '予約一覧');
	}

	public function add() {
		$this->set('title_for_layout', 'プーケットマーケット　ライブ　行くよ！');
		$this->set('comedy_live_show_id', $this->request->query['comedy_live_show_id']);
		$this->set('live_show_title_id', $this->request->query['live_show_title_id']);

		$openDateTime = $this->request->query['date'] . ' ' . $this->request->query['open'] . '00';
		$openDateTime30minBefore = date("Y/m/d H:i:s",strtotime($openDateTime . "-30 minute"));
		$systemDateTime = date("Y/m/d H:i:s");

		if ($openDateTime30minBefore < $systemDateTime) {
			$this->Flash->set('予約できるのは開場30分前までです・・・！');
			$this->redirect(
				[
				'controller' => 'comedy_live_shows',
				'action' => 'index',
				]
			);
		}

		$ikuyoComment = $this->IkuyoComments->newEntity();
		if ($this->request->is('post')) {
			$ikuyoComment = $this->IkuyoComments->patchEntity($ikuyoComment, $this->request->getData());
			if ($this->IkuyoComments->save($ikuyoComment)) {

				// email start
				$ikuyoComment = $this->IkuyoComments->get($ikuyoComment->id, [
					'contain' => ['ComedyLiveShows','LiveShowTitles']
				]);

				$unitMembersTable = TableRegistry::get('UnitMembers');

				$unitMembers = $unitMembersTable->find('all',
					[
						'conditions' => [
							'user_id' => $ikuyoComment->comedy_live_show->user_id,
						],
					]
				);
				$unitMemberMailAds = Hash::extract($unitMembers->toArray(), '{n}.mail_address');

				if (count($unitMemberMailAds) > 0) {
					(new Email('default'))
						->setConfigForInformIkuyoCommentList()
						->to($unitMemberMailAds)
						->viewVars([
							'ikuyo_comments' => $ikuyoComment,
					])
					->send();
				}
				// email end

				$this->redirect(
					[
					'action' => 'view',
					$ikuyoComment->id,
					]
				);
			} 
		}
	}
}
