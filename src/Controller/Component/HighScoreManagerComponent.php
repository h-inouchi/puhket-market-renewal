<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use App\Model\Account;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;

class HighScoreManagerComponent extends Component {

	public $components = ['Session'];

/**
 * _saveHighScore
 *
 * @param $gameName
 * @param $score
 *
 * @return void
 */
    /**
     * Initialize properties.
     *
     * @param array $config The config data.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->Controller = $this->_registry->getController();
    }

	public function saveHighScore($gameName, $score) {
		$inningHighScores = TableRegistry::get('InningHighScores');
		$query = $inningHighScores->find('getTop10', ['gameName' => $gameName]);
		$highScores = $query->all();
		if (empty($highScores) || count($highScores) < 10) {
			if ($score > 0) {
				$this->request->session()->write('high_score', $score);
				$this->Controller->redirect([
					'controller' => 'inning_high_scores',
					'action' => 'add',
					'gameName' => $gameName,
				]);
			}
		}
		foreach ($highScores as $key => $value) {
			if (Hash::get($value, 'InningHighScore.high_score', 0) < $score) {
				$this->request->session()->write('high_score', $score);
				$this->Controller->redirect([
					'controller' => 'inning_high_scores',
					'action' => 'add',
					'gameName' => $gameName,
				]);
			}
		}
	}
}
