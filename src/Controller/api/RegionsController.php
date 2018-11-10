<?php

namespace App\Controller\Api;

use App\Controller\Api\AppController;

class RegionsController extends AppController {

    public $paginate = [
        'page' => 1,
        'limit' => 5000,
        'maxLimit' => 5000,
        // 'fields' => [
        //     'id', 'name', 'code', 'country_id', 'country'
        // ],
        'sortWhitelist' => [
            'id', 'name', 'code', 'country_id'
        ]
    ];

    public function isAuthorized($user) {
        $action = $this->request->getParam('action');

        if ($action == 'index') {
            if ($user) {
                if ($user['role']['role'] == 'admin') {
                    return true;
                } else if ($user['role']['role'] == 'creator' AND $user['verified'] == true) {
                    return true;
                }
            }
        }

        return false;
    }

    public function beforeFilter(\Cake\Event\Event $event){
        parent::beforeFilter($event);
        if(in_array($this->request->param('action'), ['add', 'edit', 'delete'])){
            // $this->eventManager()->off($this->Csrf);
        }
    }

    public function initialize()
    {
        parent::initialize();

        $this->Crud->on('beforePaginate', function(\Cake\Event\Event $event) {
            $this->paginate['contain'] = ['Countries'];
            $this->paginate['conditions']['Regions.name !='] = '';
            $this->paginate['conditions']['Countries.name !='] = '';
        });
    }

}
