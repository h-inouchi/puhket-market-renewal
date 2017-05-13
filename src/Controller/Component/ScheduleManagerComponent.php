<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use App\Model\Account;
use Cake\Utility\Hash;

class ScheduleManagerComponent extends Component {

	public function getNationalHolidayFromDate($date = null) {
		// 初期値
		$y = date('Y');
		$m = date('n');

		// 日付の指定がある場合
		if($date)
		{
			$arr_date = explode('-', htmlspecialchars($date, ENT_QUOTES));

			if(count($arr_date) == 2 and is_numeric($arr_date[0]) and is_numeric($arr_date[1]))
			{
				$y = (int)$arr_date[0];
				$m = (int)$arr_date[1];
			}
		}
		// 祝日取得
		$national_holiday = $this->japan_holiday($y);

		return [
			'y' => $y,
			'm' => $m,
			'national_holiday' => $national_holiday,
		];
	}

/**
 * 祝日の取得の関数
 *
 */
	public function japan_holiday($year = '') {
		$apiKey = 'AIzaSyBttM1z_el1WDjRU7gKyTUJwm2kTs4eHhw';  // GoogleAPIキー
		$holidays = array();

		// カレンダーID
		$calendar_id = urlencode('japanese__ja@holiday.calendar.google.com');

		// 取得期間
		$start  = date($year."-01-01\T00:00:00\Z");
		$finish = date($year."-12-31\T00:00:00\Z");

		$url = "https://www.googleapis.com/calendar/v3/calendars/{$calendar_id}/events?key={$apiKey}&timeMin={$start}&timeMax={$finish}&maxResults=50&orderBy=startTime&singleEvents=true";

		$arrContextOptions = [
			"ssl" => [
				"verify_peer" => false,
				"verify_peer_name" => false,
			],
		];

		if ($results = file_get_contents($url, true, stream_context_create($arrContextOptions)))
		{
			// JSON形式で取得した情報を配列に格納
			$results = json_decode($results);

			// 年月日をキー、祝日名を配列に格納
			foreach ($results->items as $item) {
				$date = strtotime((string) $item->start->date);
				$title = (string) $item->summary;
				$holidays[date('Y-m-d', $date)] = $title;
			}

			// 祝日の配列を並び替え
			ksort($holidays);
		}

		return $holidays;
	}
}
