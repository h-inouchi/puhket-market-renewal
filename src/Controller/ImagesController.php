<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
/**
 * Images Controller
 *
 * @property \App\Model\Table\ImagesTable $Images
 */
class ImagesController extends AppController
{
	public $components = [
		'Flash',
	];

	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->deny([
			'adminIndex',
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
    public function adminIndex()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $images = $this->paginate($this->Images);

        $this->set(compact('images'));
        $this->set('_serialize', ['images']);
    }

	/**
	 * 画像を一覧表示する
	 */
	public function index(){
		$userId = Hash::get($this->request->params, 'userId', 1);
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
			$this->redirect(
				[
					'action' => 'index'
				]
			);
		}

		$this->set('user', $user);
		$this->set('title_for_layout', $user['User']['unit_name'] . '　ギャラリー');

		$this->paginate = [
			'conditions' => [
				'user_id' => $userId,
			],
			'order' => [
				'display_order' => 'ASC',
				'created' => 'DESC'
			],
		];
		$images = $this->paginate('Images');
		
		$this->set(compact('images'));
	}
	/**
	 * 画像を表示する
	 */
	public function imgview($id = null) {
		$image = $this->Images->get($id);
		$this->autoRender = false;
		$this->response->type('image/jpeg');
		$this->response->body(stream_get_contents($image->contents));
	}

	/**
	 * View method
	 *
	 * @param string|null $id Image id.
	 * @return \Cake\Network\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$image = $this->Images->get($id, [
			'contain' => ['Users']
		]);

		$this->set('image', $image);
		$this->set('_serialize', ['image']);
	}

	/**
	 * 画像を登録する
	 */
	public function add(){
		$limit = 1024 * 1024;

		$this->set('title_for_layout', '画像登録');

		$image = $this->Images->newEntity();

		if ($this->request->is('post')) {
			$image = $this->Images->patchEntity($image, $this->request->getData());
			// 画像の容量チェック
			if (Hash::get($image,'image.size') > $limit){
				$this->Flash->set('1MB以内の画像が登録可能です。');
			}
			// アップロードされた画像か
			if (!is_uploaded_file(Hash::get($image,'image.tmp_name'))){
				$this->Flash->set('アップロードする画像を選択してください。');
			}
			$image['filename'] = md5(microtime());
			$image['contents'] = file_get_contents(Hash::get($image,'image.tmp_name'));
			$image['user_id'] = $this->Auth->user('id');
			if ($this->Images->save($image)) {
				$this->Flash->set('画像をアップロードしました。');
				return $this->redirect(['action' => 'index']);
			}
			//$this->log($image->errors(),'debug');
			$this->Flash->error(__('The image could not be saved. Please, try again.'));
		}
	}


	/**
	 * Edit method
	 *
	 * @param string|null $id Image id.
	 * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$image = $this->Images->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$image = $this->Images->patchEntity($image, $this->request->getData());
			if ($this->Images->save($image)) {
				$this->Flash->success(__('The image has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The image could not be saved. Please, try again.'));
		}
		$users = $this->Images->Users->find('list', ['limit' => 200]);
		$this->set(compact('image', 'users'));
		$this->set('_serialize', ['image']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Image id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$image = $this->Images->get($id);
		if ($this->Images->delete($image)) {
			$this->Flash->success(__('The image has been deleted.'));
		} else {
			$this->Flash->error(__('The image could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
