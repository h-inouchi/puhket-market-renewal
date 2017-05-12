<?php
namespace App\Controller;

use App\Controller\API\APIController;
use Cake\Event\Event;

class APIOnAirController extends APIController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function view()
    {
        $onair = [
            "blog" => "onair",
            "id" => 0,
            "date" => "2017/05/02 09:45:47",
            "title" => "プーケットマーケットのOnAirのタイトル",
            "url" => "http://www.puhket-market.com/news",
            "body" => "",
            "category" => ["regular"], //regular or guest
            "card_size" =>1,
            "direct_url" => "http://puhket-market.com",
            "newmark" => false,
            "archive_code" => "2017-05-04",
            "type" => "TV", //TV or Radio or WEB
            "weekday" => "月曜日",
            "onair_day" => "05月11日",
            "onair_time" => "08:15-09:43",
            "station" => "NHK",
            "station_url" => "http:\/\/www.nhk.or.jp\/",
            "talent" => ["プーケットマーケット"],
            "talent_url" => ["hhttp://www.puhket-market.com"],
            "talent_text" => [""],
            "talent_thum" => ["/img/w60_h57_senzai_syasiin.png"]
        ];
        $data['hash']['tv']['mon'][] = $onair;
        $data['hash']['tv']['tue'][] = $onair;
        $data['hash']['tv']['wed'][] = $onair;
        $data['hash']['tv']['thu'][] = $onair;
        $data['hash']['tv']['fri'][] = $onair;
        $data['hash']['tv']['sat'][] = $onair;
        $data['hash']['tv']['sun'][] = $onair;
        $data['hash']['tv']['2017-05-11'][] = $onair;

        $onair['type'] = "Radio";
        $data['hash']['radio']['2017-05-11'][] = $onair;

        $onair['type'] = "WEB";
        $data['hash']['web']['2017-05-11'][] = $onair;

        $this->set('data', $data);
        $this->set('_serialize', ['data']);
    }
}