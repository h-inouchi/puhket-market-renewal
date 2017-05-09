<?php
namespace App\Controller;

use App\Controller\API\APIController;
use Cake\Event\Event;

class APIProfileController extends APIController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function view()
    {
        $profile = [
            "blog" => "profile",
            "id" => 0,
            "date" => "2016\/05\/01 11:27:50",
            "title" => "プーケットマーケット",
            "url" => "/",
            "category" => ["variety"],
            "card_size" => 1,
            "card_shoulder" => "",
            "card_title" => "",
            "card_lead" => "",
            "direct_url" => "",
            "newmark" => false,
            "thum" => "/img/w185_h174.png",
            "thum_w" => 185,
            "thum_h" => 174,
            "image" => "/img/w540_h677.jpg",
            "image_w" => 540,
            "image_h" => 677,
            "name_en" => "",
            "order" => "プーケットマーケット",
            "ruby" => "プーケットマーケット",
            "blog_url" => "",
            "catalog_url" => "",
            "fanclub_url" => "",
            "memo" => "",
            "description" => [
                [
                    "生年月日" => "1981/11/11",
                    "出身地" => "千葉県",
                    "血液型" => "A"
                ]
            ],
            "links" => [
                [
                    "title" => "プーケットマーケット",
                    "url" => "/"
                ]
            ]
        ];
        $data['hash']['variety'][] = $profile;

        $profile['category'] = ["actress"];
        $data['hash']['actress'][] = $profile;

        $profile['category'] = ["group"];
        $data['hash']['group'][] = $profile;

        $profile['category'] = ["singer"];
        $data['hash']['singer'][] = $profile;

        $profile['category'] = ["caster"];
        $data['hash']['caster'][] = $profile;

        $profile['category'] = ["actor"];
        $data['hash']['actor'][] = $profile;
        
        $profile['category'] = ["voiceactress"];
        $data['hash']['voiceactress'][] = $profile;
        
        $profile['category'] = ["culture"];
        $data['hash']['culture'][] = $profile;

        $this->set('data', $data);
        $this->set('_serialize', ['data']);
    }
}