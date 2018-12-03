<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;

class CountriesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $user = $this->Auth->user();

        $auths = array();

        array_push($auths, 'getCountries');

        if ($auths) {
            $this->Auth->allow($auths);
        } else {
            $this->Auth->deny();
        }

    }

    public function getCountries() {
        $this->autoRender = false; // avoid to render view

        $countries = $this->Countries->find('all', [
            'contain' => ['Regions' => [
                    'conditions' => ['Regions.name !=' => '']
                ]
            ],
        ]);

        $countries_json = json_encode($countries);
        $this->response->type('json');
        $this->response->body($countries_json);

    }

}
