<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class TopController extends AppController
{

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow();
	}

	public function index()
	{
		$mover = [
			"url" => "http://puhket-market.com",
			"image" =>  $this->request->webroot . "img/w784_h297_senzai_syasin.jpg",
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

		$mover_thumb = [
			"url" => "http://puhket-market.com",
			"image" => "/img/w98_h67_senzai_syasin.jpg",
		];

		$mover_thumbs [] = $mover_thumb;
		$mover_thumbs [] = $mover_thumb;
		$mover_thumbs [] = $mover_thumb;
		$mover_thumbs [] = $mover_thumb;
		$mover_thumbs [] = $mover_thumb;
		$mover_thumbs [] = $mover_thumb;
		$mover_thumbs [] = $mover_thumb;
		$mover_thumbs [] = $mover_thumb;
		$mover_thumbs [] = $mover_thumb;
		$mover_thumbs [] = $mover_thumb;
		$mover_thumbs [] = $mover_thumb;
		$mover_thumbs [] = $mover_thumb;

		$this->set('movers', $movers);
		$this->set('mover_thumbs', $mover_thumbs);

		$this->set([
			//'title' => 'プーケットマーケット',
		]);	
	}
}