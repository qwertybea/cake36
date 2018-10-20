<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Text;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize()
    { 
        parent::initialize();
        // $this->setLoc();
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $user = $this->Auth->user();
        if ($user) {
           switch ($user['role']['role']) {
            case 'creator':
                $this->Auth->allow(['logout', 'view']);
                break;
            case 'admin':
                $this->Auth->allow(['logout', 'view']);
                break;
            default :
                $this->Auth->allow(['logout']);
                break;
            }
        } else {
            $this->Auth->allow(['login', 'view', 'add']);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [
                'Documents' => [
                    'DocumentTypes',
                    'Files'
                ]
            ]
        ]);

        $has_rights = $this->hasRights($id);

        $this->set(compact('user', 'has_rights'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            $creator_id = $this->Users->Roles->find('all', [
                'conditions' => [
                    'Roles.role' => 'creator'
                ]
            ])->first()['id'];
            $user['role_id'] = $creator_id;

            if ($this->Users->save($user)) {

                $this->Flash->success(__('The user has been saved.'));

                $user = $this->Users->get($user['id'], [
                    'contain' => ['Roles']
                ]);

                $this->Auth->setUser($user);

                $uuid = Text::uuid();

                $verification = $this->Users->EmailVerifications->newEntity([
                    'user_id' => $user->id,
                    'code' => $uuid
                ]);

                if ($this->Users->EmailVerifications->save($verification)) {
                    $this->send_verification();
                }

                return $this->redirect(['controller' => 'Pages', 'action' => 'myhome']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // PATCH ENTITY MIGHT LEAVE THE PREVIOUS ROLE UNTOUCHED BUT IF...
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                if ($user['verified'] == false) {
                    $this->Flash->error(__('Your account has not been verified yet. You will not be able to create new content.'));
                    return $this->redirect(['controller' => 'EmailVerifications', 'action' => 'verifyQuery']);
                }
                
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    // we should have a unique place where this is
    public function hasRights($user_id=null)
    {
        $has_rights = false;
        if ($user_id) {
            $user = $this->Auth->user();
            if ($user) {
                if ($user['role']['role'] == 'admin') {
                    $has_rights = true;
                } elseif ($user['id'] == $user_id) {
                    $has_rights = true;
                }
            }
        }
        return $has_rights;
    }
}
