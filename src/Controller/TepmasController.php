<?php

class TepmasController extends AppController {
	public function index() {
		$this->set('title_for_layout', '無限テプマス');
	}

	public function honda() {
		$this->set('title_for_layout', 'やかましテプマス');
	}

	public function haratatsu() {
		$this->set('title_for_layout', '腹立つテプマス');
	}

	public function gekimuzu() {
		$this->set('title_for_layout', '激ムズテプマス');
	}

	public function gyaku_bowling() {
		$this->set('title_for_layout', '逆ボーリング');
	}

	public function gyaku_bill() {
		$this->set('title_for_layout', '逆ビリヤード');
	}
}