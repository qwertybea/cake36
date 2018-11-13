<?php

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

class RegionsController extends AppController {

    public $paginate = [
        'page' => 1,
        'limit' => 5000,
        'maxLimit' => 5000,
        'contain' => ['Countries'],
        'conditions' => [
            'Regions.name !=' => '',
            'Countries.name !=' => ''
        ],
        // 'fields' => [
        //     'id', 'name', 'code', 'country_id', 'country'
        // ],
        'sortWhitelist' => [
            'id', 'name', 'code', 'country_id', 'country'
        ]
    ];

    public function initialize() {
        parent::initialize();
        // Use the Bootstrap layout from the plugin.
        // $this->viewBuilder()->setLayout('admin');
        $this->viewBuilder()->setClassName('AppTwitBoot');
    }

    public function isAuthorized($user) {
        if ($user) {
            if ($user['role']['role'] == 'admin') {
                return true;
            }    
        }
        return false;
    }

    public function beforeFilter(\Cake\Event\Event $event){
        parent::beforeFilter($event);

        // $user = $this->Auth->user();
        // $auths = array();
        // if ($user) {
        //     if ($user['role']['role'] == 'admin') {
        //         array_push($auths, 'index', 'view', 'add', 'delete','edit');
        //     }    
        // }
        // if ($auths) {
        //     $this->Auth->allow($auths);
        // } else {
        //     $this->Auth->deny();
        // }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {
        $regions = $this->paginate($this->Regions);

        $this->set(compact('regions'));
        $this->set('_serialize', ['regions']);
    }

    /**
     * View method
     *
     * @param string|null $id Cocktail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $region = $this->Regions->get($id, [
            'contain' => ['Countries']
        ]);

        $this->set('region', $region);
        $this->set('_serialize', ['region']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $region = $this->Regions->newEntity();
        if ($this->request->is('post')) {
            $region = $this->Regions->patchEntity($region, $this->request->getData());
            if ($this->Regions->save($region)) {
                $this->Flash->success(__('The region has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The region could not be saved. Please, try again.'));
        }
        $countries = $this->Regions->Countries->find('list', []);
        $this->set(compact('region', 'countries'));
        $this->set('_serialize', ['region']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cocktail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        $region = $this->Regions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $region = $this->Regions->patchEntity($region, $this->request->getData());
            if ($this->Regions->save($region)) {
                $this->Flash->success(__('The region has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The region could not be saved. Please, try again.'));
        }
        $countries = $this->Regions->Countries->find('list', []);
        $this->set(compact('region', 'countries'));
        $this->set('_serialize', ['region']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cocktail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $region = $this->Regions->get($id, [
            'contain' => ['Countries', 'Documents']
        ]);

        if ($region->documents) {
            $this->Flash->error(__('This region is attached to documents so you cannot delete it.'));
        } else {
            if ($this->Regions->delete($region)) {
                $this->Flash->success(__('The region has been deleted.'));
            } else {
                $this->Flash->error(__('The region could not be deleted. Please, try again.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

}
