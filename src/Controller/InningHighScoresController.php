<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
class InningHighScoresController extends AppController {

    public function add() {
        $this->set('title_for_layout', 'ハイスコア');
        $gameName = Hash::get($this->request->query, 'gameName', 0);
        
        if ($this->request->session()->check('high_score')){
            $highScore = $this->request->session()->read('high_score');
            $this->set([
                'high_score' => $highScore,
                'game_name' => $gameName,
            ]);
        } else {
            $this->redirect(
                [
                    'controller' => 'inning_high_scores',
                    'action' => 'index',
                    'gameName' => $gameName
                ]
            );
        }
        $inningHighScore = $this->InningHighScores->newEntity();
        if ($this->request->is('post')) {
            $postedHighScore = $this->InningHighScores->patchEntity($inningHighScore, $this->request->getData());
            $postedHighScore['high_score'] = $this->request->session()->read('high_score');
            $this->__save($postedHighScore);
            $this->request->session()->delete('high_score');
        }
        $this->set(compact('inningHighScore'));
        $this->set('_serialize', ['inningHighScore']);
    }

    public function index() {
        $gameName = Hash::get($this->request->query, 'gameName', 0);
        $query = $this->InningHighScores->find('getTop10', ['gameName' => $gameName]);
        $inning_high_scores = $query->all();

        $this->set([
            'title_for_layout' => 'ハイスコア一覧',
            'inning_high_scores' => $inning_high_scores,
            'game_name' => $gameName,
        ]);
    }

    private function __save($posted){
        if ($this->InningHighScores->save($posted)) {
            $this->redirect(
                [
                    'controller' => 'inning_high_scores',
                    'action' => 'index',
                    'gameName' => Hash::get($posted, 'InningHighScore.game_name'),
                ]
            );
        }
    }
}
