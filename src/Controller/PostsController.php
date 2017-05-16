<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController
{
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->deny(
			[
				'add',
				'delete',
				'adminIndex',
				'edit'
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
		$posts = $this->paginate($this->Posts);

		foreach ($posts as $post) {
			$post['post_text'] = nl2br($post['post_text']);
		}

		$this->set(compact('posts'));
		$this->set('_serialize', ['posts']);

		$this->set('title_for_layout', 'ニュース一覧');
	}

	/**
	 * adminIndex method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function adminIndex() {
		$userId = $this->Auth->user('id');
		$this->paginate = [
			'conditions' => [
				'user_id' => $userId,
			],
			'order' => [
				'display_order' => 'ASC',
				'created' => 'DESC'
			],
		];
		$posts = $this->paginate('Posts');
		$this->set('posts', $posts);
		$this->set('title_for_layout', '管理者用 ニュース一覧');
	}

	/**
	 * View method
	 *
	 * @param string|null $id Post id.
	 * @return \Cake\Network\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$post = $this->Posts->get($id, [
			'contain' => ['Users']
		]);

		$this->set('post', $post);
		$this->set('_serialize', ['post']);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$post = $this->Posts->newEntity();
		if ($this->request->is('post')) {
			$post = $this->Posts->patchEntity($post, $this->request->getData());
			if ($this->Posts->save($post)) {
				$this->Flash->success(__('The post has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The post could not be saved. Please, try again.'));
		}
		$users = $this->Posts->Users->find('list', ['limit' => 200]);
		$this->set(compact('post', 'users'));
		$this->set('_serialize', ['post']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Post id.
	 * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$post = $this->Posts->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$post = $this->Posts->patchEntity($post, $this->request->getData());
			if ($this->Posts->save($post)) {
				$this->Flash->success(__('The post has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The post could not be saved. Please, try again.'));
		}
		$users = $this->Posts->Users->find('list', ['limit' => 200]);
		$this->set(compact('post', 'users'));
		$this->set('_serialize', ['post']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Post id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$post = $this->Posts->get($id);
		if ($this->Posts->delete($post)) {
			$this->Flash->success(__('The post has been deleted.'));
		} else {
			$this->Flash->error(__('The post could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
