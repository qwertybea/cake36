<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;

class EmailVerificationsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $user = $this->Auth->user();

        $func = array();

        if ($user) {
           switch ($user['role']) {
            case 'creator':
                if (!$user['verified']) {
                    array_push($func, 'verification', 'send_verification', 'verifyQuery');
                }
                break;
            case 'admin':
                if (!$user['verified']) {
                    array_push($func, 'verification', 'send_verification', 'verifyQuery');
                }
                break;
            }
        } else {
        }

        if ($func) {
            $this->Auth->allow($func);
        } else {
            $this->Auth->deny();
        }
        
    }

    public function verification($slug=null)
    {
        if ($this->request->query) {
            $query = $this->request->query;
            $verification = $this->EmailVerifications->find('all', [
                'conditions' => [
                    'user_id' => $query['uid'],
                    'code' => $query['code']
                ]
            ])->first();
            
            if ($verification) {

                $user = $this->EmailVerifications->Users->get($verification->user_id);

                $user->verified = true;

                if ($this->EmailVerifications->Users->save($user)) {
                    $this->Auth->setUser($user);
                    $this->Flash->success(__('Your account has been verified.'));
                } else {
                    $this->Flash->error(__('The account has failed to be verified.'));
                }
            } else {
                $this->Flash->error(__('Wrong verification information.'));
            }
        }
       
        return $this->redirect(['controller' => 'Pages', 'action' => 'myhome']);
    }

    public function send_verification()
    {
         parent::send_verification();
    }

    public function verifyQuery()
    {
        if ($this->request->is('post')) {
            $this->send_verification();
            return $this->redirect(['controller' => 'Pages', 'action' => 'myhome']);
        }
    }

}
