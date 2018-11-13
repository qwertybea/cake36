<?php

namespace App\Controller\Admin;

use Cake\Controller\Controller;

class AppController extends Controller {

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize() {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');

        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password'
                    ],
                    'contain' => [
                        'Roles'
                    ]
                ]
            ],
            'loginAction' =>[
                'prefix' => false,
                'controller' => 'Users',
                'action' => 'login'
             ],
            'loginRedirect' => [
                'prefix' => false,
                'controller' => 'Pages',
                'action' => 'myhome'
            ],
            'logoutRedirect' => [
                'prefix' => false,
                'controller' => 'Pages',
                'action' => 'myhome'
            ],
            'authorize' => ['Controller'],
             // Si pas autorisé, on renvoit sur la page précédente
            'unauthorizedRedirect' => $this->referer()
        ]);

        $this->Auth->allow(['changeLang', 'login', 'activate', 'verification', 'send_verification']);
    }

    public function isAuthorized($user) {
        return false;
    }

}
