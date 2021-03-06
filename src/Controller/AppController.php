<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Utility\Text;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	public $viewClass = '\WyriHaximus\TwigView\View\TwigView';
	public $helpers = ['Html', 'Form'];
	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * e.g. `$this->loadComponent('Security');`
	 *
	 * @return void
	 */
	public function initialize()
	{
		parent::initialize();

		$this->loadComponent('RequestHandler');
		$this->loadComponent('Flash');
		$this->loadComponent('Auth', [
			'loginRedirect' =>[],
			'logoutRedirect' => [
				'controller' => 'Users',
				'action' => 'login'
			],
			'authorize' => ['Controller'],
			'unauthorizedRedirect' => [
				'controller' => 'users',
				'action' => 'login'
			],
		]);
		$this->loadComponent('Cookie', [
			'expires' => '1 day'
		]);
		$uuid = $this->Cookie->read('pktmkt_uuid');
		if (strlen($uuid) == 0) {
			$uuid = Text::uuid();
			$oneMonth = 86400 * 31;
			$this->Cookie->write('pktmkt_uuid', $uuid, false, $oneMonth);
		}
		/*
		 * Enable the following components for recommended CakePHP security settings.
		 * see http://book.cakephp.org/3.0/en/controllers/components/security.html
		 */
		$this->loadComponent('Security');
		$this->loadComponent('Csrf');
	}

	/**
	 * Before render callback.
	 *
	 * @param \Cake\Event\Event $event The beforeRender event.
	 * @return \Cake\Network\Response|null|void
	 */
	public function beforeRender(Event $event)
	{		
		if (!array_key_exists('_serialize', $this->viewVars) &&
			in_array($this->response->type(), ['application/json', 'application/xml'])
		) {
			$this->set('_serialize', true);
		}

		$this->set([
			'controllerName' => $this->name,
			'actionNmame' => $this->request->action,
			'ogImageUrl' => Router::url('/img/og/senzai_syasin.jpg', true),
		]);
	}

	public function beforeFilter(Event $event)
	{
		// ログインが必要かどうかの設定
		// ここでは全許可して、要ログインのものは個別のコントローラで制御
		$this->Auth->allow();
		$this->set('authUser', $this->Auth->user());
	}

	public function isAuthorized($user) {
		// Admin can access every action
		if (isset($user['role']) && $user['role'] === 'admin') {
			return true;
		}
		// author
		if (isset($user['role']) && $user['role'] === 'author') {
			if ($this->request->controller == 'blog_posts') {
				return true;
			}
		}
		// oogiri
		if (isset($user['role']) && $user['role'] === 'oogiri') {
			if ($this->request->controller == 'oogiri_scores') {
				return true;
			}
		}
		// デフォルトは拒否
		return false;
	}
}
