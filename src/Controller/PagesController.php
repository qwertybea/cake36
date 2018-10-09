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

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        
        $this->Auth->allow(['myhome', 'about']);
    }

    /**
     * Displays a view
     *
     * @param array ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function display(...$path)
    {
        $count = count($path);
        if (!$count) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        try {
            $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    public function myhome()
    {
        $doc_table = $textTable = TableRegistry::get('Documents');
        $int_table = $textTable = TableRegistry::get('Interactions');

        $new_docs = $doc_table->find('all', [
            'limit' => 5,
            'conditions' => [
                'Documents.published' => 1,
                'Documents.deleted' => 0
            ]
        ])
        ->contain(['Users'])
        ->order(['Documents.created' => 'DESC']);


        $query = $int_table->find();

        $popular_docs = $int_table->find('all')
        ->select(['views' => $query->func()->count('Interactions.id')])
        ->contain(['InteractiveMethods', 'Documents', 'Users'])
        ->where([
            'InteractiveMethods.method' => 'view',
             'Documents.published' => 1,
             'Documents.deleted' => 0
        ])
        ->group(['document_id'])
        ->order(['count(Interactions.id)' => 'DESC'])
        ->limit(5)
        // get all the other fields too (not just the select)
        ->enableAutoFields(true)
        ->toList();
        //debug($popular_docs_list);

        $this->set(compact('new_docs', 'popular_docs'));
    }

    public function about()
    {
        
    }
}
