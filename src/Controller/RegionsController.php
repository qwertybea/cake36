<?php

namespace App\Controller;

use App\Controller\AppController;

class RegionsController extends AppController {

    public $paginate = [
        'page' => 1,
        'limit' => 5000,
        'maxLimit' => 5000,
        'contain' => ['Countries'],
        'conditions' => ['Regions.name !=' => ''],
/*        'fields' => [
            'id', 'name', 'description'
        ],
*/        'sortWhitelist' => [
            'id', 'name', 'description'
        ]
    ];

    public function initialize()
    {
        parent::initialize();

        $this->viewBuilder()->setLayout('monopage');
        
        $my_var = 123;

        $this->set(compact('my_var'));

    }

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

        if ($user) {
            if ($user['role']['role'] == 'admin') {
                return true;
            } else if ($user['role']['role'] == 'creator' AND $user['verified'] == true) {
                return true;
            }
        }

        return false;
    }

    public function beforeFilter(\Cake\Event\Event $event){
        parent::beforeFilter($event);
        if($this->request->param('action') === 'add'){
            $this->eventManager()->off($this->Csrf);
        }
    }

    public function getRegions() {
        $this->autoRender = false; // avoid to render view

        $categories = $this->Categories->find('all', [
            'contain' => ['Subcategories'],
        ]);

        $categoriesJ = json_encode($categories);
        $this->response->type('json');
        $this->response->body($categoriesJ);

    }

}
