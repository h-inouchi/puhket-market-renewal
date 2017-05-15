<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
class UsersController extends AppController
{
	public function beforeFilter(Event $event){
		parent::beforeFilter($event);
		$actionName = Hash::get($this->request->params, 'action');
		if ($actionName == 'add') {
			// ベーシック認証に使用するユーザー名とパスワードを書き込む
			$loginId = 'pktmkt_user';
			$loginPassword = '%7YrWQzG$u';
			if (!isset($_SERVER['PHP_AUTH_USER'])) {
				header('WWW-Authenticate: Basic realm="Please enter your ID and password"');
				header('HTTP/1.0 401 Unauthorized');
				die("id / password Required");
			} else {
				if ($_SERVER['PHP_AUTH_USER'] != $loginId || $_SERVER['PHP_AUTH_PW'] != $loginPassword) {
					header('WWW-Authenticate: Basic realm="Please enter your ID and password"');
					header('HTTP/1.0 401 Unauthorized');
					die("Invalid id / password combination.  Please try again");
				}
			}
		}
	}

	public function index()
	{
		$users = $this->paginate($this->Users);

		$this->set(compact('users'));
		$this->set('_serialize', ['users']);
	}

	public function view($id)
	{
		$user = $this->Users->get($id);
		$this->set(compact('user'));
	}

	public function add()
	{
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(['action' => 'add']);
			}
			$this->Flash->error(__('Unable to add the user.'));
		}
		$this->set('user', $user);
	}

	public function edit($id = null)
	{
		$user = $this->Users->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData());
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The user could not be saved. Please, try again.'));
		}
		$this->set(compact('user'));
		$this->set('_serialize', ['user']);
	}

	public function login()
	{
		if ($this->request->is('post')) {
			$user = $this->Auth->identify();
			if ($user) {
				$this->Auth->setUser($user);

				/****** setting redirect ****************/
				$loginRole = Hash::get($this->Auth->user(), 'role', '');

				// Admin can access every action
				if ($loginRole === 'admin') {
					$this->Auth->loginRedirect = ['controller' => 'personal_schedules', 'action' => 'index'];
				}
				// author
				if ($loginRole === 'author') {
					$this->Auth->loginRedirect = ['controller' => 'blog_posts', 'action' => 'add'];
				}
				// oogiri
				if ($loginRole === 'oogiri') {
					$this->Auth->loginRedirect = ['controller' => 'oogiri_scores', 'action' => 'view_sum'];
				}
				/****** setting redirect ****************/

				//return $this->redirect($this->Auth->redirectUrl());
				return $this->redirect($this->Auth->loginRedirect);
			}
			$this->Flash->error(__('Invalid username or password, try again'));
		}
	}

	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}
}