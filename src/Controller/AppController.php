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
    }

    public function isAuthorized($user) {
        return false;
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

}
