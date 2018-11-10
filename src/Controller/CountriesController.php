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

    public function getCountries()
    {
        if ($this->request->is('ajax')) {

            $countries = $this->Countries->find('all', []);

            $this->set('countries', $countries);
            $this->set('_serialize', ['countries']);

        } else {
            return $this->redirect(['controller' => 'Pages', 'action' => 'myhome']);
        }
    }

}
