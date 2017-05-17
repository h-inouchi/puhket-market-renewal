<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\ORM\TableRegistry;
class BatterBoxesController extends AppController {
    public $components = [
        'BaseBallGameManager', 'HighScoreManager',
    ];

    const GAME_NAME = 'baseball';

    const ST_NO_RUNNER  = "ランナーなし";
    const ST_1ST_BASE   = "ランナー1塁";
    const ST_2ND_BASE   = "ランナー2塁";
    const ST_3RD_BASE   = "ランナー3塁";
    const ST_12_BASE    = "ランナー1、2塁";
    const ST_13_BASE    = "ランナー1、3塁";
    const ST_23_BASE    = "ランナー2、3塁";
    const ST_FULL_BASE  = "ランナー満塁";

    const RSLT_OUT      = 0;
    const RSLT_HIT      = 1;
    const RSLT_2BASE_HIT= 2;
    const RSLT_3BASE_HIT= 3;
    const RSLT_HOME_RUN = 4;
    const RSLT_FOUR_B   = 5;

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->deny([]);
    }

    public function edit() {
        if (empty($this->request->query)) {
        } else if ($this->request->is('get')) {
            $this->redirect([
                'action' => 'edit',
            ]);
        }
        $this->set('title_for_layout', '１イニングで何点取れるか？！コースを読んで打ち返せ！野球　ゲーム　プーケットマーケット');
        $ballCount = Hash::get($this->request->query, 'ballCount', 0);
        $strikeCount = Hash::get($this->request->query, 'strikeCount', 0);
        $swingPanelNumber = Hash::get($this->request->query, 'panelNumber', 0);

        $outCount = Hash::get($this->request->query, 'outCount', 0);
        //$inningScore = Hash::get($this->request->query, 'inningScore', 0);
        $inningScore = 0;
        if ($this->request->session()->check('inningScore')) {
            $inningScore = $this->request->session()->read('inningScore');
        }
        $baseStatus = Hash::get($this->request->query, 'baseStatus', self::ST_NO_RUNNER);

        $swingBallHeight = $this->_getBallHeight($swingPanelNumber);
        $swingBallCourse = $this->_getBallCourse($swingPanelNumber);
        $swingFlgs = $this->_getSwingFlgs($swingBallHeight, $swingBallCourse);
        $swingFlg = Hash::get($swingFlgs, 'swingFlg');
        $strongSwingFlg = Hash::get($swingFlgs, 'strongSwingFlg');

        $pitchedPanelNumber = $this->BaseBallGameManager->getPitchedPanelNumber();
        $pitchedBallHeight = $this->_getBallHeight($pitchedPanelNumber);
        $pitchedBallCourse = $this->_getBallCourse($pitchedPanelNumber);
        $strikePitchFlgs = $this->_getStrikePitchFlg($pitchedBallHeight, $pitchedBallCourse);
        $strikePitchFlg = Hash::get($strikePitchFlgs, 'strikeFlg');
        $missControlFlg = Hash::get($strikePitchFlgs, 'missControlFlg');

        $meetHeight = abs($swingBallHeight - $pitchedBallHeight);
        $meetCourse = abs($swingBallCourse - $pitchedBallCourse);

        $battingResult = '';
        //3OUT NEXT INNING RESET
        if ($outCount == 3) {
            $outCount = 0;
            $inningScore = 0;
            $baseStatus = self::ST_NO_RUNNER;
            $battingResult = 'さあ！！バッターボックスに先頭バッターが入りました！攻撃が始まります！！<br>';
        }

        if ($swingFlg === 1) {
            switch ($meetHeight + $meetCourse) {
                case 0:
                    if ($missControlFlg === 1 && $strongSwingFlg === 1) {
                        $battingResult = $battingResult . '完璧な当たり！ホームランだ！！';
                        $this->_resetCount($ballCount, $strikeCount);
                        $this->_updateScoreStatus(self::RSLT_HOME_RUN, $outCount, $inningScore, $baseStatus);
                        break;
                    } else if ($strongSwingFlg === 1) {
                        $battingResult = $battingResult . '振りぬいた！ツーベース　ヒット！';
                        $this->_resetCount($ballCount, $strikeCount);
                        $this->_updateScoreStatus(self::RSLT_2BASE_HIT, $outCount, $inningScore, $baseStatus);
                        break;
                    } else {
                        $battingResult = $battingResult . '読み通りのコース！クリーンヒット！';
                        $this->_resetCount($ballCount, $strikeCount);
                        $this->_updateScoreStatus(self::RSLT_HIT, $outCount, $inningScore, $baseStatus);
                        break;
                    }
                case 1:
                    if ($missControlFlg === 1 && $strongSwingFlg === 1) {
                        $battingResult = $battingResult . 'やや詰まった打球がいい方向に飛んだ！ツーベース　ヒット！';
                        $this->_resetCount($ballCount, $strikeCount);
                        $this->_updateScoreStatus(self::RSLT_2BASE_HIT, $outCount, $inningScore, $baseStatus);
                        break;
                    }
                    if ($strikePitchFlg === 1) {
                        if ($missControlFlg === 1 || $strongSwingFlg === 1) {
                            $battingResult = $battingResult . 'これはラッキー！ポテンヒット！';
                            $this->_resetCount($ballCount, $strikeCount);
                            $this->_updateScoreStatus(self::RSLT_HIT, $outCount, $inningScore, $baseStatus);
                            break;
                        } else {
                            $battingResult = $battingResult . 'ナイスボールでしたがバットに当てました！ファウル';
                            if ($strikeCount <= 1) {
                                $strikeCount++;
                            }
                            break;
                        }
                    } else {
                        $battingResult = $battingResult . 'ボール球に食らいついた！ファウル';
                        if ($strikeCount <= 1) {
                            $strikeCount++;
                        }
                    }
                    break;

                case 2:
                    if ($strikePitchFlg === 1) {
                        $battingResult = $battingResult . '打ち損じだ！アウト！';
                        $this->_resetCount($ballCount, $strikeCount);
                        $this->_updateScoreStatus(self::RSLT_OUT, $outCount, $inningScore, $baseStatus);
                    } else {
                        if ($strikeCount <= 1) {
                            $battingResult = $battingResult . 'ストライクからボールへの変化球！空振り！';
                            $strikeCount++;
                        } else {
                            $battingResult = $battingResult . 'ストライクからボールへの変化球！空振り三振！！';
                            $this->_resetCount($ballCount, $strikeCount);
                            $this->_updateScoreStatus(self::RSLT_OUT, $outCount, $inningScore, $baseStatus);
                        }
                    }
                    break;

                default: //3マス以上離れている場合
                    if ($strikePitchFlg === 1) {
                        if ($strikeCount <= 1) {
                            $battingResult = $battingResult . '見逃しストライク！';
                            $strikeCount++;
                        } else {
                            $battingResult = $battingResult . '見逃しストライク！三振！！';
                            $this->_resetCount($ballCount, $strikeCount);
                            $this->_updateScoreStatus(self::RSLT_OUT, $outCount, $inningScore, $baseStatus);
                        }
                    } else {
                        if ($ballCount <= 2) {
                            $battingResult = $battingResult . 'ボール';
                            $ballCount++;
                        } else {
                            $battingResult = $battingResult . 'ボール。フォアボール。';
                            $this->_resetCount($ballCount, $strikeCount);
                            $this->_updateScoreStatus(self::RSLT_FOUR_B, $outCount, $inningScore, $baseStatus);
                        }
                    }
                    break;
            }
        } else {
            if ($swingPanelNumber === 0) {
                $this->Flash->set('マスをタップ！！<br>あなたはバッター！<br><br>ピッチャーが投げる<br>コースを読んでね！');
                $battingResult = 'さあ！！バッターボックスに先頭バッターが入りました！攻撃が始まります！！';
                $pitchedPanelNumber = 0;
            } else {
                //最初からボール狙い　＝　見逃し
                if ($strikePitchFlg === 1) {
                    if ($strikeCount <= 1) {
                        $battingResult = $battingResult . '見逃しストライク！';
                        $strikeCount++;
                    } else {
                        $battingResult = $battingResult . '見逃しストライク！三振！！';
                        $this->_resetCount($ballCount, $strikeCount);
                        $this->_updateScoreStatus(self::RSLT_OUT, $outCount, $inningScore, $baseStatus);
                    }
                } else {
                    if ($ballCount <= 2) {
                        $battingResult = $battingResult . 'ボール';
                        $ballCount++;
                    } else {
                        $battingResult = $battingResult . 'ボール。フォアボール。';
                        $this->_resetCount($ballCount, $strikeCount);
                        $this->_updateScoreStatus(self::RSLT_FOUR_B, $outCount, $inningScore, $baseStatus);
                    }
                }
            }
        }

        //3OUT CHANGE MESSAGE
        if ($outCount == 3) {
            $battingResult = $battingResult . ' ３アウトチェンジ！';
        }
        $this->set(
            [
                'pitchedPanelNumber' => $pitchedPanelNumber,
                'ballCount' => $ballCount,
                'strikeCount' => $strikeCount,
                'outCount' => $outCount,
                'inningScore' => $inningScore,
                'baseStatus' => $baseStatus,
                'battingResult' => $battingResult
            ]
        );

    }

    protected function _getBallHeight($panelNumber) {
        $ballHeight = 0;
        if ($panelNumber >= 1 && $panelNumber <= 5) {
            $ballHeight = 1;
        }
        if ($panelNumber >= 6 && $panelNumber <= 10) {
            $ballHeight = 2;
        }
        if ($panelNumber >= 11 && $panelNumber <= 15) {
            $ballHeight = 3;
        }
        if ($panelNumber >= 16 && $panelNumber <= 20) {
            $ballHeight = 4;
        }
        if ($panelNumber >= 21 && $panelNumber <= 25) {
            $ballHeight = 5;
        }

        return $ballHeight;
    }

    protected function _getBallCourse($panelNumber) {
        $ballCourse = 0;
        if ($panelNumber % 5 === 1) {
            $ballCourse = 1;
        }
        if ($panelNumber % 5 === 2) {
            $ballCourse = 2;
        }
        if ($panelNumber % 5 === 3) {
            $ballCourse = 3;
        }
        if ($panelNumber % 5 === 4) {
            $ballCourse = 4;
        }
        if ($panelNumber % 5 === 0) {
            $ballCourse = 5;
        }

        return $ballCourse;
    }

    protected function _getSwingFlgs($ballHeight, $ballCourse) {
        $swingFlg = 0;
        $strongSwingFlg = 0;
        $strikeHeight = 0;
        $strikeCourse = 0;
        if ($ballHeight >= 2 && $ballHeight <= 4) {
            $strikeHeight = 1;
        }
        if ($ballCourse >= 2 && $ballCourse <= 4) {
            $strikeCourse = 1;
        }
        if ($strikeHeight === 1 && $strikeCourse === 1) {
            $swingFlg = 1;
        }
        $strongSwingShuffle = range(1,5);
        shuffle($strongSwingShuffle);
        if (Hash::get($strongSwingShuffle, 0) === 5) {
            $strongSwingFlg = 1;
        }
        $swingFlgs = [
            'swingFlg' => $swingFlg,
            'strongSwingFlg' => $strongSwingFlg,
        ];
        return $swingFlgs;
    }

    protected function _getStrikePitchFlg($ballHeight, $ballCourse) {
        $strikeFlg = 0;
        $missControlFlg = 0;
        $strikeHeight = 0;
        $strikeCourse = 0;
        if ($ballHeight >= 2 && $ballHeight <= 4) {
            $strikeHeight = 1;
        }
        if ($ballCourse >= 2 && $ballCourse <= 4) {
            $strikeCourse = 1;
        }
        if ($strikeHeight === 1 && $strikeCourse === 1) {
            $strikeFlg = 1;
        }
        $missControlShuffle = range(1,5);
        shuffle($missControlShuffle);
        if (Hash::get($missControlShuffle, 0) === 5) {
            $missControlFlg = 1;
        }
        $strikeFlgs = [
            'strikeFlg' => $strikeFlg,
            'missControlFlg' => $missControlFlg,
        ];
        return $strikeFlgs;
    }

    protected function _resetCount(&$ballCount, &$strikeCount) {
        $ballCount = 0;
        $strikeCount = 0;
    }

/**
 * _changeScoreStatus スコアやベース状況を更新する
 *
 * @param $resultDiv    self RSLT_OUT= 0;
 * @param $outCount
 * @param $inningScore
 * @param $baseStatus   self ST_NO_RUNNER   = 0;
 */
    protected function _updateScoreStatus($resultDiv, &$outCount, &$inningScore, &$baseStatus) {
        // FourBall
        if ($resultDiv == self::RSLT_FOUR_B){

            if (strcmp($baseStatus, self::ST_NO_RUNNER) === 0) {
                $baseStatus = self::ST_1ST_BASE;
            }
            else if (strcmp($baseStatus, self::ST_1ST_BASE) === 0) {
                $baseStatus = self::ST_12_BASE;
            }
            else if (strcmp($baseStatus, self::ST_2ND_BASE) === 0) {
                $baseStatus = self::ST_12_BASE;
            }
            else if (strcmp($baseStatus, self::ST_3RD_BASE) === 0) {
                $baseStatus = self::ST_13_BASE;
            }
            else if (strcmp($baseStatus, self::ST_12_BASE) === 0) {
                $baseStatus = self::ST_FULL_BASE;
            }
            else if (strcmp($baseStatus, self::ST_13_BASE) === 0) {
                $baseStatus = self::ST_FULL_BASE;
            }
            else if (strcmp($baseStatus, self::ST_23_BASE) === 0) {
                $baseStatus = self::ST_FULL_BASE;
            }
            else if (strcmp($baseStatus, self::ST_FULL_BASE) === 0) {
                $baseStatus = self::ST_FULL_BASE;
                $inningScore++;
            }
        }
        // HIT
        if ($resultDiv == self::RSLT_HIT){

            if (strcmp($baseStatus, self::ST_NO_RUNNER) === 0) {
                $baseStatus = self::ST_1ST_BASE;
            }
            else if (strcmp($baseStatus, self::ST_1ST_BASE) === 0) {
                $baseStatus = self::ST_12_BASE;
            }
            else if (strcmp($baseStatus, self::ST_2ND_BASE) === 0) {
                $baseStatus = self::ST_13_BASE;
            }
            else if (strcmp($baseStatus, self::ST_3RD_BASE) === 0) {
                $baseStatus = self::ST_1ST_BASE;
                $inningScore++;
            }
            else if (strcmp($baseStatus, self::ST_12_BASE) === 0) {
                $baseStatus = self::ST_FULL_BASE;
            }
            else if (strcmp($baseStatus, self::ST_13_BASE) === 0) {
                $baseStatus = self::ST_12_BASE;
                $inningScore++;
            }
            else if (strcmp($baseStatus, self::ST_23_BASE) === 0) {
                $baseStatus = self::ST_13_BASE;
                $inningScore++;
            }
            else if (strcmp($baseStatus, self::ST_FULL_BASE) === 0) {
                $baseStatus = self::ST_FULL_BASE;
                $inningScore++;
            }
        }
        //2BASE HIT
        if ($resultDiv == self::RSLT_2BASE_HIT){
            if (strcmp($baseStatus, self::ST_NO_RUNNER) === 0) {
                $baseStatus = self::ST_2ND_BASE;
            }
            else if (strcmp($baseStatus, self::ST_1ST_BASE) === 0) {
                $baseStatus = self::ST_23_BASE;
            }
            else if (strcmp($baseStatus, self::ST_2ND_BASE) === 0) {
                $baseStatus = self::ST_2ND_BASE;
                $inningScore++;
            }
            else if (strcmp($baseStatus, self::ST_3RD_BASE) === 0) {
                $baseStatus = self::ST_2ND_BASE;
                $inningScore++;
            }
            else if (strcmp($baseStatus, self::ST_12_BASE) === 0) {
                $baseStatus = self::ST_23_BASE;
                $inningScore++;
            }
            else if (strcmp($baseStatus, self::ST_13_BASE) === 0) {
                $baseStatus = self::ST_23_BASE;
                $inningScore++;
            }
            else if (strcmp($baseStatus, self::ST_23_BASE) === 0) {
                $baseStatus = self::ST_2ND_BASE;
                $inningScore = $inningScore + 2;
            }
            else if (strcmp($baseStatus, self::ST_FULL_BASE) === 0) {
                $baseStatus = self::ST_23_BASE;
                $inningScore = $inningScore + 2;
            }
        }
        //3BASE HIT (未実装　これを実装するときにソースをコンポーネント化したほうがいいかも)
        if ($resultDiv == self::RSLT_3BASE_HIT){

        }
        //HOME RUN
        if ($resultDiv == self::RSLT_HOME_RUN){
            switch ($baseStatus) {
                case self::ST_NO_RUNNER:
                    $inningScore++;
                    break;
                case self::ST_1ST_BASE:
                case self::ST_2ND_BASE:
                case self::ST_3RD_BASE:
                    $inningScore = $inningScore + 2;
                    break;
                case self::ST_12_BASE:
                case self::ST_13_BASE:
                case self::ST_23_BASE:
                    $inningScore = $inningScore + 3;
                    break;
                case self::ST_FULL_BASE:
                    $inningScore = $inningScore + 4;
                    break;
            }
            $baseStatus = self::ST_NO_RUNNER;
        }
        // OUT
        if($resultDiv == self::RSLT_OUT) {
            if ($outCount <= 2) {
                $outCount++;
            }
        }
        // HighScore
        if ($outCount === 3) {
            $this->request->session()->write('inningScore', 0);
            $this->HighScoreManager->saveHighScore(self::GAME_NAME, $inningScore);
            $inningScore = 0;
        }
        $this->request->session()->write('inningScore', $inningScore);
    }
}
