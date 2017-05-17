<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use App\Model\Account;
use Cake\Utility\Hash;

class BaseBallGameManagerComponent extends Component {

	const STRIKE_PITCHED	= 1;
	const BALL_PITCHED		= 2;

	public function getPitchedPanelNumber() {

		$strikeBalls = range(1,3);
		shuffle($strikeBalls);
		$pitchedStrike = 0;
		if (Hash::get($strikeBalls, 0) === 3) {
			$pitchedStrike = self::BALL_PITCHED;
		} else {
			$pitchedStrike = self::STRIKE_PITCHED;
		}
		$numbers = [];
		if ($pitchedStrike === self::STRIKE_PITCHED) {
			$numbers[] = 7;
			$numbers[] = 8;
			$numbers[] = 9;
			$numbers[] = 12;
			$numbers[] = 13;
			$numbers[] = 14;
			$numbers[] = 17;
			$numbers[] = 18;
			$numbers[] = 19;
		} else {
			$numbers[] = 1;
			$numbers[] = 2;
			$numbers[] = 3;
			$numbers[] = 4;
			$numbers[] = 5;
			$numbers[] = 6;
			$numbers[] = 10;
			$numbers[] = 11;
			$numbers[] = 15;
			$numbers[] = 16;
			$numbers[] = 20;
			$numbers[] = 21;
			$numbers[] = 22;
			$numbers[] = 23;
			$numbers[] = 24;
			$numbers[] = 25;
		}

		//$numbers = range(1, 25);
		shuffle($numbers);
		$pitchedPanelNumber = Hash::get($numbers, 0);

		return $pitchedPanelNumber;
	}
}
