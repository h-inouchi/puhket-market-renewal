<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
class TodouhukensController extends AppController {
	public $components = [
		'HighScoreManager',
	];

	const TODOUHUKEN_IMAGE_DIR = '/assets/image/todouhuken/';

	const VICTORY = '勝ち！！';

	const LOSE = '負け・・・.';

	const GAME_NAME = 'todouhuken';

/**
 * index 
 */
	public function index() {
		if (empty($this->request->query)) {
		} else if ($this->request->is('get')) {
			$this->redirect([
				'action' => 'index',
			]);
		}
		$this->set('title_for_layout', '都道府県じゃんけん');

		// どこをタップされたか。北：2、西：4、東：6、南：8
		$tappedPanelNumber = Hash::get($this->request->query, 'panelNumber', 0);
		
		// 前回まで表示されていた都道府県の情報を取得する。
		$beforeTodouhuken = [];
		$beforeTodouhukenId = 0;
		if ($tappedPanelNumber != 0) {
			$beforeTodouhukenId = $this->_getTodouhukenId();
			$beforeTodouhuken = $this->Todouhukens->get($beforeTodouhukenId);
		} else {
			// 初期処理（リセットなど）
			$this->_setRenzokuVictory(0);
		}

		// 今回表示する都道府県の情報を取得する。（前回と同じ都道府県になったら再取得する）
		$shuffledTodouhukenId = $this->_getShuffledTodouhukenId();
		if ($shuffledTodouhukenId == $beforeTodouhukenId) {
			while ($shuffledTodouhukenId == $beforeTodouhukenId) {
				$shuffledTodouhukenId = $this->_getShuffledTodouhukenId();
			}
		}
		$shuffledTodouhuken = $this->Todouhukens->get($shuffledTodouhukenId);

		// 今回表示する都道府県の情報を、前回表示したものとして上書き保存する
		$this->_setTodouhukenId(Hash::get($shuffledTodouhuken, 'id'));

		// 勝敗を判定して、表示する
		$winOrLose = '';
		if (!empty($beforeTodouhuken)) {
			$winOrLose = $this->_getWinOrLose($tappedPanelNumber, $beforeTodouhuken, $shuffledTodouhuken);	
		}
		if (!strlen($winOrLose) == 0) {
			$this->Flash->set($winOrLose);
		}

		// 連勝情報を記録する
		$renzokuVictory = $this->_getRenzokuVictory();
		if ($winOrLose === self::VICTORY) {
			$renzokuVictory = $renzokuVictory + 1;
		} else if ($winOrLose === self::LOSE) {
			// HighScoreだった場合リダイレクトされてしまうのでセッションのスコアを消しておく
			$this->_setRenzokuVictory(0);
			// HighScoreなら、HighScoreを記録する
			$this->HighScoreManager->saveHighScore(self::GAME_NAME, $renzokuVictory);
			$renzokuVictory = 0;
		}

		$this->_setRenzokuVictory($renzokuVictory);

		// 今回表示する都道府県のファイル名を取得
		$shuffledTodouhukenName = Hash::get($shuffledTodouhuken, 'name');
		$shuffledTodouhukenFile = self::TODOUHUKEN_IMAGE_DIR . Hash::get($shuffledTodouhuken, 'filename');

		// ビューに表示する情報を渡す
		$this->set([
			'todouhukenName' => $shuffledTodouhukenName,
			'shuffleTodouhuken' => $shuffledTodouhukenFile,
			'renzokuVictory' => $renzokuVictory,
		]);
	}

/**
 * _getWinOrLose 勝敗の取得
 *
 * @param $tappedPanelNumber
 * @param $beforeTodouhuken
 * @param $shuffledTodouhuken
 *
 * @return $winOrLose
 */
	protected function _getWinOrLose($tappedPanelNumber, $beforeTodouhuken, $shuffledTodouhuken) {
		$winOrLose = '';
		$befNorthRanking = Hash::get($beforeTodouhuken, 'rom_north_ranking');
		$aftNorthRanking = Hash::get($shuffledTodouhuken, 'from_north_ranking');
		$befEastRanking = Hash::get($beforeTodouhuken, 'from_east_ranking');
		$aftEastRanking = Hash::get($shuffledTodouhuken, 'from_east_ranking');

		if ($tappedPanelNumber == 2) {
			if ($befNorthRanking > $aftNorthRanking) {
				$winOrLose = self::VICTORY;
			} else {
				$winOrLose = self::LOSE;
			}
		}
		if ($tappedPanelNumber == 8) {
			if ($befNorthRanking > $aftNorthRanking) {
				$winOrLose = self::LOSE;
			} else {
				$winOrLose = self::VICTORY;
			}
		}

		if ($tappedPanelNumber == 6) {
			if ($befEastRanking > $aftEastRanking) {
				$winOrLose = self::VICTORY;
			} else {
				$winOrLose = self::LOSE;
			}
		}
		if ($tappedPanelNumber == 4) {
			if ($befEastRanking > $aftEastRanking) {
				$winOrLose = self::LOSE;
			} else {
				$winOrLose = self::VICTORY;
			}
		}

		return $winOrLose;
	}

/**
 * todouhuokenId　の　getter / setter
 */
	protected function _getTodouhukenId() {
		$todouhukenId = 0;
		if ($this->request->session()->check('todouhukenId')) {
			$todouhukenId = $this->request->session()->read('todouhukenId');
		}
		return $todouhukenId;
	}

	protected function _setTodouhukenId($todouhukenId) {
		$this->request->session()->write('todouhukenId', $todouhukenId);
	}

/**
 * renzokuVictory　の　getter / setter
 */
	protected function _getRenzokuVictory() {
		$renzokuVictory = 0;
		if ($this->request->session()->check('renzokuVictory')) {
			$renzokuVictory = $this->request->session()->read('renzokuVictory');
		}
		return $renzokuVictory;
	}

	protected function _setRenzokuVictory($renzokuVictory) {
		$this->request->session()->write('renzokuVictory', $renzokuVictory);
	}

/**
 * ランダムな都道府県ID (1～47)を取得する
 *
 * @return $shuffledTodouhukenId
 */
	protected function _getShuffledTodouhukenId() {
		$todouhukenShuffle = range(1,47);
		shuffle($todouhukenShuffle);
		$shuffledTodouhukenId = Hash::get($todouhukenShuffle, 0);

		return $shuffledTodouhukenId;
	}
}