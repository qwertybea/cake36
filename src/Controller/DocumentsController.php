<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;

/**
 * Documents Controller
 *
 * @property \App\Model\Table\DocumentsTable $Documents
 *
 * @method \App\Model\Entity\Document[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $user = $this->Auth->user();
        if ($user) {
           switch ($user['role']) {
            case 'creator':
                $this->Auth->allow(['index', 'view', 'add', 'delete', 'myWork', 'has_rights'
                        // temp permissions
                        ,'edit'
                    ]);
                break;
            case 'admin':
                $this->Auth->allow(['index', 'viewAllDocuments', 'view', 'add', 'delete', 'myWork', 'has_rights'
                    // temp permissions
                        ,'edit'
                    ]);
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

        $this->paginate = [
            'contain' => ['DocumentTypes', 'Users'],
            'conditions' => [
                'Documents.published' => 1,
                'Documents.deleted' => 0
            ],
        ];
        $documents = $this->paginate($this->Documents);

        $this->set(compact('documents'));
    }

    public function viewAllDocuments($value='')
    {
        $this->paginate = [
            'contain' => ['DocumentTypes', 'Users'],
            'conditions' => [
                'Documents.deleted' => 0
            ],
        ];
        $documents = $this->paginate($this->Documents);

        $this->set(compact('documents'));
    }

    /**
     * View method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => ['DocumentTypes', 'Users', 'Interactions']
        ]);

        $this->set('document', $document);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($type_id = null)
    {
        $document = $this->Documents->newEntity();
        $type = $this->Documents->DocumentTypes
            ->find()
            ->where(['id' => $type_id])
            ->first();

        if ($type != null) {
            $document['type_id'] = $type['id'];
            $document['user_id'] = $this->Auth->user()['id'];
            if ($this->Documents->save($document)) {
                $this->Flash->success(__('The document has been saved.'));
                // $type_name = Inflector::camelize($type['type']);
                // redirect to a specific controller
                // will add after we have many types
                // return $this->redirect(['controller' => $type_name.'Documents', 'action' => 'edit', $document['id']]);

                // TEMP
                $textTable = TableRegistry::get('TextDocuments');
                $textDoc = $textTable->newEntity([
                    'document_id' => $document['id']
                ]);
                $textTable->save($textDoc);

                return $this->redirect(['controller' => 'Documents', 'action' => 'edit', $document['id']]);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
            $this->redirect($this->referer());
        } else {
            $this->redirect($this->referer());
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $document = $this->Documents->patchEntity($document, $this->request->getData());
            if ($this->Documents->save($document)) {
                $text = $this->request->getData()['content'];

                // TEMP
                $textTable = TableRegistry::get('TextDocuments');
                $textDoc = $textTable->find('all', [
                    'conditions' => [
                        'document_id' => $document['id']
                    ]
                ])->first();
                debug($textDoc);
                $textDoc['text'] = $text;
                $textTable->save($textDoc);

                $this->Flash->success(__('The document has been saved.'));

                return $this->redirect(['action' => 'myWork']);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
        }
        $textDocument = $this->Documents->TextDocuments->find('all', [
                'conditions' => [
                    'document_id' => $document['id']
                ]
            ])->first();
        $this->set(compact('document', 'textDocument'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $document = $this->Documents->get($id);
        $document['deleted'] = 1;
        if ($this->Documents->save($document)) {
            $this->Flash->success(__('The document has been deleted.'));
        } else {
            $this->Flash->error(__('The document could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

    public function myWork()
    {
        $documents = $this->Documents->find('all', [
            'contain' => ['documentTypes', 'users'],
            'conditions' => [
                'Documents.user_id' => $this->Auth->user()['id'],
                'Documents.deleted' => 0
            ],
        ]);

        $documentTypes = $this->Documents->DocumentTypes
            ->find();

        $this->set(compact(['user', 'documents', 'documentTypes']));
    }
}
