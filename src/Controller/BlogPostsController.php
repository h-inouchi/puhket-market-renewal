<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
/**
 * BlogPosts Controller
 *
 * @property \App\Model\Table\BlogPostsTable $BlogPosts
 */
class BlogPostsController extends AppController
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
	 * index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index() {
		$userId = Hash::get($this->request->params, 'userId', 1);

		$user = $this->BlogPosts->Users->get($userId);

		$unitUsers = $this->BlogPosts->Users->find('all',
			[
				'conditions' => [
					'unit_name' => $user->unit_name,
				],
			]
		);

		$unitUserIds = Hash::extract($unitUsers->toArray(), '{n}.id');
		$this->paginate = [
			'conditions' => [
				'user_id IN' => $unitUserIds,
			],
			'order' => [
				'created' => 'DESC'
			],
		];

		$blogPosts = $this->paginate('BlogPosts');

		foreach ($blogPosts as $post) {
			$post->post_text = nl2br($post->post_text);
		}
		$this->set('blogPosts', $blogPosts);
		$this->set('title_for_layout', 'ブログ記事一覧');
	}

	/**
	 * adminIndex method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function adminIndex() {
		$userId = Hash::get($this->request->params, 'userId', 1);

		$user = $this->BlogPosts->Users->get($userId);

		$unitUsers = $this->BlogPosts->Users->find('all',
			[
				'conditions' => [
					'unit_name' => $user->unit_name,
				],
			]
		);

		$unitUserIds = Hash::extract($unitUsers->toArray(), '{n}.id');

		$this->paginate = [
			'conditions' => [
				'user_id IN' => $unitUserIds,
			],
			'order' => [
				'created' => 'DESC'
			],
		];
		$blogPosts = $this->paginate('BlogPosts');

		$this->set('blogPosts', $blogPosts);
		$this->set('title_for_layout', '管理者用ブログ記事一覧');
	}

	/**
	 * View method
	 *
	 * @param string|null $id Blog Post id.
	 * @return \Cake\Network\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$blogPost = $this->BlogPosts->get($id, [
			'contain' => ['Users']
		]);
		$blogPost['post_text'] = nl2br($blogPost['post_text']);
		$blogPost['post_text'] = preg_replace("/【(.*?)】/s", "<h2>【$1】</h2>", $blogPost['post_text']);
		$this->set('blogPost', $blogPost);
		$this->set('title_for_layout', $blogPost['BlogPost']['title']);	
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$blogPost = $this->BlogPosts->newEntity();
		if ($this->request->is('post')) {
			$blogPost = $this->BlogPosts->patchEntity($blogPost, $this->request->getData());
			if ($this->BlogPosts->save($blogPost)) {
				$this->Flash->success(__('The blog post has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The blog post could not be saved. Please, try again.'));
		}
		$users = $this->BlogPosts->Users->find('list', ['limit' => 200]);
		$this->set(compact('blogPost', 'users'));
		$this->set('_serialize', ['blogPost']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Blog Post id.
	 * @return \Cake\Network\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$blogPost = $this->BlogPosts->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$blogPost = $this->BlogPosts->patchEntity($blogPost, $this->request->getData());
			if ($this->BlogPosts->save($blogPost)) {
				$this->Flash->success(__('The blog post has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The blog post could not be saved. Please, try again.'));
		}
		$users = $this->BlogPosts->Users->find('list', ['limit' => 200]);
		$this->set(compact('blogPost', 'users'));
		$this->set('_serialize', ['blogPost']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Blog Post id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$blogPost = $this->BlogPosts->get($id);
		if ($this->BlogPosts->delete($blogPost)) {
			$this->Flash->success(__('The blog post has been deleted.'));
		} else {
			$this->Flash->error(__('The blog post could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
