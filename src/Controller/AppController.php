<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\I18n\I18n;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');

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
                'controller' => 'Users',
                'action' => 'login'
             ],
            'loginRedirect' => [
                'controller' => 'Pages',
                'action' => 'myhome'
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'myhome'
            ],
            'authorize' => ['Controller'],
             // Si pas autorisé, on renvoit sur la page précédente
            'unauthorizedRedirect' => $this->referer()
        ]);

        $this->setLoc();

        // array_push($this->paginate['contain'], 'Countries');
        // debug($this->paginate);
        // die();

    }

    public function isAuthorized($user) {
        return false;
    }

    // http://www.bravo-kernel.com/2015/04/how-to-build-a-cakephp-3-rest-api-in-minutes#3-Enable-the-API
    // 3.b) configure the api
    use \Crud\Controller\ControllerTrait;
    public $components = [
        'RequestHandler',
        'Crud.Crud' => [
            'actions' => [
                'Crud.Index',
                'Crud.View',
                'Crud.Add',
                'Crud.Edit',
                'Crud.Delete'
            ],
            'listeners' => [
                'Crud.Api',
                'Crud.ApiPagination',
                'Crud.ApiQueryLog'
            ]
        ]
    ];



    public function changeLang($lang = 'en_US') {
        I18n::setLocale($lang);
        $this->request->getSession()->write('Config.language', $lang);
        return $this->redirect($this->request->referer());
    }

    public function setLoc()
    {
        I18n::setLocale($this->request->getSession()->read('Config.language'));
    }

    public static function array_on_key($array, $key)
    {
        if($array) {
            foreach ($array as $value) {
                $result[] = $value[$key];
            }
        } else {
            $result = array();
        }
        return $result;
    }

    public function update_cover($document=null, $file=null, $remove_cover=null)
    {
        if ($document) {

            if ($document->file->status) {
                if ($remove_cover) {
                    $this->delete_file($document->file->id);
                } elseif ($file['name']) {
                    $this->delete_file($document->file->id);
                    $file = $this->add_file($file);
                    $document->document_cover = $file['id'];
                }
            } else {
                if ($file['name'] && !$remove_cover) {
                    $file = $this->add_file($file);
                    $document->document_cover = $file['id'];
                }
            }
        }

        return $document;
    }

    // Some special characters get changed when saved to the computer
    // we are thus unable to retrive them afterwards
    public function add_file($file_data)
    {
        $fileTable = TableRegistry::get('files');
        $file = $fileTable->newEntity();

        if (!empty($file_data['name'])) {
            $fileName = $file_data['name'];
            $uploadPath = 'Files/';
            $uploadFile = $uploadPath . $fileName;
            if (move_uploaded_file($file_data['tmp_name'], 'img/' . $uploadFile)) {
                //$file = $fileTable->patchEntity($file, $this->request->getData());
                $file->name = $fileName;
                $file->path = $uploadPath;
                if ($fileTable->save($file)) {
                    $this->Flash->success(__('File has been uploaded and inserted successfully.'));
                } else {
                    $this->Flash->error(__('Unable to upload file, please try again.'));
                }
            } else {
                $this->Flash->error(__('Unable to save file, please try again.'));
            }
        } else {
            $this->Flash->error(__('Please choose a file to upload.'));
        }
        return $file;
    }

    public function delete_file($file_id=null)
    {
        $fileTable = TableRegistry::get('files');
        $file = $fileTable->get($file_id);
        $file->status = 0;
        if ($fileTable->save($file)) {
            $this->Flash->success(__('The file has been deleted.'));
        } else {
            $this->Flash->error(__('The file could not be deleted. Please, try again.'));
        }
    }

    public function send_verification()
    {
        if ($this->Auth->user()) {
            
            $userTable = TableRegistry::get('Users');
            $user = $userTable->get($this->Auth->user()['id'], [
                'contain' => ['EmailVerifications']
            ]);

            $user_email = $user->email;
            $subject = 'Verification email for Story City';

            $uuid = $user->email_verification->code;

            $webroot = $this->request->webroot;

            $href = __('localhost{0}EmailVerifications/verification?uid={1}&code={2}', $webroot, $user->id, $uuid);

            $link = __('<a href="{0}">Verify my email</a>', $href);

            $msg = __('Welcome to Story city in order to get access to all our functionalities please verify your email by clicking the link bellow. <br><br>{0}', $link);

            // TODO: REMOVE COMMENT TO SEND EMAIL
            $email = new Email('default');
            $email->emailFormat('html');
            $email->to($user_email)->subject($subject)->send($msg);

            $this->Flash->success(__('You have been sent an email to verify your account.'));

        } else {
            $this->Flash->error(__('You must be logged in to send a verification email.'));
            return $this->redirect($this->referer());
        }
    }

    function getRealIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}
