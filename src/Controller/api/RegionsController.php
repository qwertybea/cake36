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



        $action = $this->request->getParam('action');
        

        if ($action == 'delete') {
            
            $id = $this->request->getParam('id');
            $name = $this->request->getParam('name');

            $region = $this->Regions->get($id, [

                'contain' => ['Documents'],

            ]);

            if ($region['documents']) {
                
                // if documents are connected to the region we do not allow to delete it
                // we then change the response code and content to tell the browser
                // after that we kill the query to prevent deletion

                $error = array(
                    'error' => array(
                        'msg' => 'This region is attached to documents so you cannot delete it.'
                    )
                );
                // echo json_encode($error);

                $this->response = $this->response->withStatus(409);
                $this->response = $this->response->withType('json');
                $this->response = $this->response->withStringBody(json_encode($error, JSON_PRETTY_PRINT));
                // var_dump($response);
                // var_dump($response);
                $this->response->send();
                // not necesseray put just making sure we end the process here
                die();
                // return $this->response;

            }

        }
    }

}
