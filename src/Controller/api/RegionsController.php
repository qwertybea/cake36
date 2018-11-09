<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;
use Cake\Event\Event;

class RegionsController extends AppController {

    public $paginate = [
        'page' => 1,
        'limit' => 100,
        'maxLimit' => 150,
/*        'fields' => [
            'id', 'name', 'description'
        ],
*/        'sortWhitelist' => [
            'id', 'name', 'description'
        ]
    ];

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $user = $this->Auth->user();

        $auths = array();

        if ($user) {
           switch ($user['role']['role']) {
            case 'creator':
	            if ($user['verified']) {
                	array_push($auths, 'index');
	            }
                break;
            case 'admin':
                array_push($auths, 'index');
                break;
            }
        } else {
        }

        if ($auths) {
            $this->Auth->allow($auths);
        } else {
            $this->Auth->deny();
        }

    }

    public function isAuthorized($user) {
        if ($user) {
           switch ($user['role']['role']) {
            case 'creator':
	            if ($user['verified']) {
                	return true;
	            }
                break;
            case 'admin':
               	return true; 
                break;
            }
        }

        return false;
        
    }

}
