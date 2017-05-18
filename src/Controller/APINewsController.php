<?php
namespace App\Controller;

use App\Controller\API\APIController;
use Cake\Event\Event;

class APINewsController extends APIController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function view()
    {
        $news = [
            "blog" => "news",
            "id" => 0,
            "date" => "2017/05/02 09:45:47",
            "title" => "プーケットマーケットのニュースのタイトル",
            "url" => "http://www.puhket-market.com/news",
            "body" => "",
            "category" => ["pickup","announce"],
            "card_size" =>2,
            "card_shoulder" => "",
            "card_title" => "",
            "card_lead" => "",
            "direct_url" => "http://puhket-market.com",
            "newmark" => false,
            "display_top" => false,
            "text_hide" => false,
            "thum" => $this->request->webroot . "img/w382_size_change.png",
            "thum_h" => 250,
            "thum_w" => 382,
            "image" => "../img/w579_senzai_capture.png",
            "image_h" => 397,
            "image_w" => 579,
            "youtube_id" => "",
            "talent" => ["プーケットマーケット","いのうち","ひだか","ほんだ"],
            "talent_url" => ["http://puhket-market.com","http://puhket-market.com"]
        ];
        $data['list'][] = $news;
        $data['list'][] = $news;
        $data['list'][] = $news;
        $data['list'][] = $news;
        $data['list'][] = $news;
        $data['list'][] = $news;
        $data['list'][] = $news;
        $data['list'][] = $news;

        $this->set('data', $data);
        $this->set('_serialize', ['data']);
    }
}