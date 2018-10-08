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
                $this->Auth->allow(['index', 'view', 'add', 'delete', 'myWork', 'hasRights', 'canView', 'handleFavorite', 'myFavorites'
                        // temp permissions
                        ,'edit'
                    ]);
                break;
            case 'admin':
                $this->Auth->allow(['index', 'viewAllDocuments', 'view', 'add', 'delete', 'myWork', 'hasRights', 'canView', 'handleFavorite', 'myFavorites'
                    // temp permissions
                        ,'edit'
                    ]);
                break;
            }
        } else {
            $this->Auth->allow(['index', 'view', 'has_rights', 'canView', 'handleFavorite']);
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
        if ($this->canView($id)) {
            $document = $this->Documents->get($id, [
                'contain' => ['DocumentTypes', 'Users', 'Interactions', 'TextDocuments']
            ]);

            $view_method_id = $this->Documents->Interactions->InteractiveMethods->find('all', [
                'conditions' => [
                    'InteractiveMethods.method' => 'view'
                ]
            ])->first()['id'];

            $favorite_method_id = $this->Documents->Interactions->InteractiveMethods->find('all', [
                'conditions' => [
                    'InteractiveMethods.method' => 'favorite'
                ]
            ])->first()['id'];

            $view_query = $this->Documents->Interactions->find('all', [
                'conditions' => [
                    'Interactions.document_id' => $id,
                    'Interactions.interactiveMethod_id' => $view_method_id
                ]
            ]);

            if ($this->Auth->user()) {
                $favorite_query = $this->Documents->Interactions->find('all', [
                    'conditions' => [
                        'Interactions.document_id' => $id,
                        'Interactions.user_id' => $this->Auth->user()['id'],
                        'Interactions.interactiveMethod_id' => $favorite_method_id
                    ]
                ])->first();
                $favorited = $favorite_query != null;
            } else {
                $favorited = null;
            }
            

            $view_count = $view_query->count();

            $has_rights = $this->hasRights($id);


            $this->handleViewInteraction($id);

            $this->set(compact('document', 'view_count', 'favorited', 'has_rights'));
        } else {
            $this->Flash->error(__('You do not have the right to view this document.'));
            return $this->redirect($this->referer());
        }
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
        if ($this->hasRights($id)) {
            $document = $this->Documents->find('all', [
                'contain' => [],
                'conditions' => [
                    'Documents.id' => $id
                ]
            ])->first();
            if ($document) {
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
            } else {
                $this->Flash->error(__('No such document exists.'));
                return $this->redirect($this->referer());
            }
        } else {
            $this->Flash->error(__('You do not have the right to edit this document.'));
            return $this->redirect($this->referer());
        }
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
        if ($this->hasRights($id)) {
            $this->request->allowMethod(['post', 'delete']);
            $document = $this->Documents->find('all', [
                'conditions' => [
                    'Documents.id' => $id
                ]
            ])->first();
            if ($document) {
                $document['deleted'] = 1;
                if ($this->Documents->save($document)) {
                    $this->Flash->success(__('The document has been deleted.'));
                } else {
                    $this->Flash->error(__('The document could not be deleted. Please, try again.'));
                }

                return $this->redirect($this->referer());
            } else {
                $this->Flash->error(__('No such document exists.'));
                return $this->redirect($this->referer());
            }
            
            
        } else {
            $this->Flash->error(__('You do not have the right to delete this document.'));
            return $this->redirect($this->referer());
        }
    }

    public function myWork()
    {
        $this->paginate = [
            'contain' => ['DocumentTypes', 'Users'],
            'conditions' => [
                'Documents.user_id' => $this->Auth->user()['id'],
                'Documents.deleted' => 0
            ],
        ];
        $documents = $this->paginate($this->Documents);

        $documentTypes = $this->Documents->DocumentTypes
            ->find();

        $this->set(compact('user', 'documents', 'documentTypes'));
    }

    public function myFavorites()
    {

        $favorites = $this->Documents->Interactions->find('all')
        ->select(['document_id'])
        ->contain(['InteractiveMethods'])
        ->where([
            'InteractiveMethods.method' => 'favorite',
            'Interactions.user_id' => $this->Auth->user()['id'],
        ])->toList();

        $favorites = AppController::array_on_key($favorites, 'document_id');

        if ($favorites) {
            $conditions = [
                'Documents.id IN' => $favorites,
                'Documents.published' => 1,
                'Documents.deleted' => 0
            ];
        } else {
            $conditions = [
                'TRUE' => false
            ];
        }
        $this->paginate = [
            'contain' => [
                'DocumentTypes',
                'Users'
            ],
            'conditions' => $conditions,
        ];
        $documents = $this->paginate($this->Documents);

        $this->set(compact('documents'));
    }

    public function hasRights($doc_id=null)
    {
        $has_rights = false;
        if ($doc_id) {
            $user = $this->Auth->user();
            if ($user) {
                if ($user['role'] == 'admin') {
                    $has_rights = true;
                } elseif ($user['role'] == 'creator') {
                    $doc = $this->Documents->find('all', [
                        'conditions' => [
                            'Documents.id' => $doc_id,
                            'Documents.user_id' => $user['id']
                        ]
                    ])->first();
                    if ($doc) {
                        $has_rights = true;
                    }
                }
            }
        }
        return $has_rights;
    }

    public function canView($doc_id=null)
    {
        $has_rights = false;
        if ($doc_id) {

            $doc = $this->Documents->find('all', [
                'conditions' => [
                    'Documents.id' => $doc_id
                ]
            ])->first();

            if($doc['deleted'] == false) {
                if ($doc['published'] == true) {
                    $has_rights = true;
                } else {
                    $user = $this->Auth->user();

                    if ($user) {
                        
                        switch ($user['role']) {
                            case 'creator':
                                
                                if ($doc['user_id'] == $user['id']) {
                                    $has_rights = true;
                                }

                                break;
                            
                            case 'admin':
                                $has_rights = true;
                                break;
                        }

                    }
                    
                }

            }

        }
        return $has_rights;
    }

    public function handleViewInteraction($doc_id)
    {
        $user = $this->Auth->user();
        $visitor_id = $this->Documents->Users->find('all', [
            'conditions' => [
                'Users.role' => 'visitor'
            ]
        ])->first()['id'];

        if ($user) {
            $user_id = $this->Auth->user()['id'];
        } else {
            $user_id = $visitor_id;
        }
        
        $interactive_method_id = $this->Documents->Interactions->InteractiveMethods->find('all', [
            'conditions' => [
                'InteractiveMethods.method' => 'view'
            ]
        ])->first()['id'];

        $interaction = $this->Documents->Interactions->find('all', [
            'conditions' => [
                'Interactions.document_id' => $doc_id,
                'Interactions.user_id' => $user_id,
                'Interactions.interactiveMethod_id' => $interactive_method_id
            ]
        ])->first();

        //if (!$interaction || $user_id == $visitor_id) {
            $new_interaction = $this->Documents->Interactions->newEntity([
                'document_id' => $doc_id,
                'user_id' => $user_id,
                'interactiveMethod_id' => $interactive_method_id
            ]);
            $this->Documents->Interactions->save($new_interaction);
        //}
    }

    public function handleFavorite($doc_id)
    {
        $user = $this->Auth->user();
        if ($user) {
            $favorite_method_id = $this->Documents->Interactions->InteractiveMethods->find('all', [
                'conditions' => [
                    'InteractiveMethods.method' => 'favorite'
                ]
            ])->first()['id'];
            $favorite = $this->Documents->Interactions->find('all', [
                'conditions' => [
                    'Interactions.document_id' => $doc_id,
                    'Interactions.user_id' => $this->Auth->user()['id'],
                    'Interactions.interactiveMethod_id' => $favorite_method_id
                ]
            ])->first();
            if ($favorite) {
                $this->Documents->Interactions->delete($favorite);
                $favorited = false;
            } else {
                $favorite = $this->Documents->Interactions->newEntity([
                    'document_id' => $doc_id,
                    'user_id' => $user['id'],
                    'interactiveMethod_id' => $favorite_method_id
                ]);
                $this->Documents->Interactions->save($favorite);
                $favorited = true;
            }

            return $this->redirect(['controller' => 'Documents', 'action' => 'view', $doc_id]);
        } else {
            $this->Flash->error(__('Login to favorite documents.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        
    }

}
