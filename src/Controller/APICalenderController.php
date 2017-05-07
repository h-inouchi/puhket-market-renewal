<?php
namespace App\Controller;

use App\Controller\API\APIController;
use Cake\Event\Event;

class APICalenderController extends APIController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function view()
    {
        $data['list'] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
        $this->set('data', $data);
        $this->set('_serialize', ['data']);
    }
}