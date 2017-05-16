<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
/**
 * YoutubeUrls Controller
 *
 * @property \App\Model\Table\YoutubeUrlsTable $YoutubeUrls
 */
class YoutubeUrlsController extends AppController
{
	const YOUTUBE_CATEGORY_DOUKE = 1;
	const YOUTUBE_CATEGORY_PKTMKT = 2;

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->deny(
			[
				'add',
				'delete',
				'adminIndex',
				'edit'
			]);
	}


/**
 * 外部リンク(iframe含む)を一覧表示する
 */
	public function link(){
		$userId = Hash::get($this->request->params, 'userId', 1);
		$user = $this->YoutubeUrls->Users->get($userId);

		if (!$user) {
			$this->redirect(
				[
					'action' => 'index'
				]
			);
		}
		$this->set('user', $user);
		$this->set('title_for_layout', $user->unit_name . '　リンク');

		$this->paginate = [
			'conditions' => [
				'user_id' => $userId,
				'youtube_category' => self::YOUTUBE_CATEGORY_DOUKE,//道化太陽のサンチャンネル
			],
			'order' => [
				'created' => 'DESC'
			],
		];
		$youtubeUrls = $this->paginate('YoutubeUrls');
		
		$this->set('youtubeUrls', $youtubeUrls);
	}

/**
 * YoutubeURL(iframe)を一覧表示する
 */
	public function index(){
		$userId = Hash::get($this->request->params, 'userId', 1);
		$user = $this->YoutubeUrls->Users->get($userId);

		if (!$user) {
			$this->redirect(
				[
					'action' => 'index'
				]
			);
		}
		$this->set('user', $user);
		$this->set('title_for_layout', $user->unit_name . '動画一覧');

		$this->paginate = [
			'conditions' => [
				'user_id' => $userId,
				'youtube_category' => self::YOUTUBE_CATEGORY_PKTMKT,//プーケットマーケットの動画
			],
			'order' => [
				'created' => 'DESC'
			],
		];
		$youtubeUrls = $this->paginate('YoutubeUrls');

		$this->set('youtubeUrls', $youtubeUrls);
	}

	/**
	 * adminIndex method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function adminIndex()
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
			$youtubeUrl->user_id = $this->Auth->user('id');
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
