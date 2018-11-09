<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * TextDocuments Controller
 *
 * @property \App\Model\Table\TextDocumentsTable $TextDocuments
 *
 * @method \App\Model\Entity\TextDocument[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TextDocumentsController extends AppController
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
                $this->Auth->allow(['index', 'view', 'add', 'edit', 'myWork', 'has_rights']);
                break;
            case 'administrator':
                $this->Auth->allow(['index', 'view', 'add', 'edit', 'myWork', 'has_rights']);
                break;
            }
        } else {
            $this->Auth->allow(['index', 'view', 'has_rights']);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $textDocuments = $this->paginate($this->TextDocuments);

        $this->set(compact('textDocuments'));
    }

    /**
     * View method
     *
     * @param string|null $id Text Document id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $textDocument = $this->TextDocuments->get($id, [
            'contain' => []
        ]);

        $this->set('textDocument', $textDocument);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $textDocument = $this->TextDocuments->newEntity();
        if ($this->request->is('post')) {
            $textDocument = $this->TextDocuments->patchEntity($textDocument, $this->request->getData());
            if ($this->TextDocuments->save($textDocument)) {
                $this->Flash->success(__('The text document has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The text document could not be saved. Please, try again.'));
        }
        $this->set(compact('textDocument'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Text Document id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $textDocument = $this->TextDocuments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $textDocument = $this->TextDocuments->patchEntity($textDocument, $this->request->getData());
            if ($this->TextDocuments->save($textDocument)) {
                $this->Flash->success(__('The text document has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The text document could not be saved. Please, try again.'));
        }
        $this->set(compact('textDocument'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Text Document id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $textDocument = $this->TextDocuments->get($id);
        if ($this->TextDocuments->delete($textDocument)) {
            $this->Flash->success(__('The text document has been deleted.'));
        } else {
            $this->Flash->error(__('The text document could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
