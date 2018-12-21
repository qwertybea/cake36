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
    public function initialize()
    {
        parent::initialize();
        // $this->setLoc();
        ini_set("allow_url_fopen", true);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $user = $this->Auth->user();

        $auths = array();

        array_push($auths, 'findDocuments', 'search', 'index', 'view', 'canView', 'handleFavorite');

        if ($user) {
           switch ($user['role']['role']) {
            case 'creator':
                array_push($auths, 'add', 'delete', 'myWork', 'hasRights', 'myFavorites', 'changeCover'
                        // temp permissions
                        ,'edit', 'getRegions'
                    );
                break;
            case 'admin':
                array_push($auths, 'index', 'viewAllDocuments', 'view', 'add', 'delete', 'myWork', 'myFavorites', 'changeCover'
                    // temp permissions
                        ,'edit', 'getRegions'
                    );
                break;
            }
        } else {
        }

        if ($auths) {
            $this->Auth->allow($auths);
        } else {
            $this->Auth->deny();
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
            'contain' => ['DocumentTypes', 'Users', 'Files'],
            'conditions' => [
                'Documents.published' => 1,
                'Documents.deleted' => 0
            ],
            'order' => ['Documents.created' => 'DESC'],
        ];
        $documents = $this->paginate($this->Documents);

        $this->set(compact('documents'));
    }

    public function viewAllDocuments($value='')
    {
        $this->paginate = [
            'contain' => ['DocumentTypes', 'Users', 'Files'],
            'conditions' => [
                'Documents.deleted' => 0
            ],
            'order' => ['Documents.created' => 'DESC'],
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
                'contain' => [
                    'DocumentTypes', 
                    'Users' => 'Roles', 
                    'Interactions', 
                    'TextDocuments', 
                    'Files',
                    'Countries',
                    'Regions',
                ]
            ]);

            $view_method_id = $this->Documents->Interactions->InteractiveMethods->find('all', [
                'conditions' => [
                    'InteractiveMethods.method' => 'view'
                ]
            ])->first()['id'];

            $view_query = $this->Documents->Interactions->find('all', [
                'conditions' => [
                    'Interactions.document_id' => $id,
                    'Interactions.interactiveMethod_id' => $view_method_id
                ]
            ]);

            if ($this->Auth->user()) {
                $favorite_method_id = $this->Documents->Interactions->InteractiveMethods->find('all', [
                    'conditions' => [
                        'InteractiveMethods.method' => 'favorite'
                    ]
                ])->first()['id'];

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
        $user = $this->Auth->user();
        if ($user['verified']) {
            $document = $this->Documents->newEntity();
            $type = $this->Documents->DocumentTypes
                ->find()
                ->where(['DocumentTypes.id' => $type_id])
                ->first();

            if ($type != null) {
                $document['type_id'] = $type['id'];
                $document['user_id'] = $this->Auth->user()['id'];

                $no_cover = $this->Documents->Files->find('all', [
                    'conditions' => [
                        'Files.status' => false
                    ]
                ])->first();

                if(!$no_cover) {

                    $no_cover = $this->Documents->Files->newEntity([
                        'status' => 0
                    ]);

                    $this->Documents->Files->save($no_cover);

                }

                $document['document_cover'] = $no_cover['id'];

                // if (in_array($_SERVER['REMOTE_ADDR'], ["127.0.0.1", "::1"])) {

                //     $country = 'Canada';
                //     $region = 'Quebec';

                // } else {
                    
                //     $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$this->getRealIpAddr());

                //     debug($xml);
                // }

                $country = 'Canada';
                $region = 'Quebec';

                $country = $this->Documents->Countries->find('all', [

                    'contain' => ['Regions'],

                    'conditions' => [

                        'Countries.name' => $country

                    ]

                ])->first();

                $val_region = false;
                if ($country != null) {
                    
                    $associated_regions = parent::array_on_key($country->regions, 'name');

                    $val_region = in_array($region, $associated_regions);
                    
                }

                if ($val_region) {
                    $country = 'Canada';
                    $region = 'Quebec';

                    $country = $this->Documents->Countries->find('all', [

                    'conditions' => [

                        'Countries.name' => $country

                    ]

                    ])->first();


                    $region = $this->Documents->Regions->find('all', [

                        'conditions' => [

                            'Regions.name' => $region

                        ]

                    ])->first();
                }

                // debug($country);
                // debug($region);
                // die();

                $document['country_id'] = $country->id;
                $document['region_id'] = $region->id;

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
        } else {
            $this->Flash->error(__('You\'re account is not verified.'));
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
                'contain' => ['Files'],
                'conditions' => [
                    'Documents.id' => $id
                ]
            ])->first();
            if ($document) {
                if ($this->request->is(['patch', 'post', 'put'])) {
                    $document = $this->Documents->patchEntity($document, $this->request->getData());

                    $remove_cover = $this->request->getData()['remove_cover'];

                    $file_data = null;
                    $this->update_cover($document, $file_data, $remove_cover);

                    if ($this->Documents->save($document)) {
                        $text = $this->request->getData()['content'];

                        // TEMP
                        $textTable = TableRegistry::get('TextDocuments');
                        $textDoc = $textTable->find('all', [
                            'conditions' => [
                                'TextDocuments.document_id' => $document['id']
                            ]
                        ])->first();

                        //debug($textDoc);
                        $textDoc['text'] = $text;
                        $textTable->save($textDoc);

                        $this->Flash->success(__('The document has been saved.'));

                        return $this->redirect(['action' => 'myWork']);
                    }
                    $this->Flash->error(__('The document could not be saved. Please, try again.'));
                }
                $textDocument = $this->Documents->TextDocuments->find('all', [
                        'conditions' => [
                            'TextDocuments.document_id' => $document['id']
                        ]
                    ])->first();



                $countries = $this->Documents->Countries->find('list', ['limit' => 300]);
                $regions = $this->Documents->Regions->find('list', [
                    'conditions' => [
                        'Regions.country_id' => $document->country_id,
                        'Regions.name !=' => ''
                    ],
                ]);

                $this->set(compact('document', 'textDocument', 'countries', 'regions'));
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
            'contain' => ['DocumentTypes', 'Users', 'Files'],
            'conditions' => [
                'Documents.user_id' => $this->Auth->user()['id'],
                'Documents.deleted' => 0
            ],
        ];
        $documents = $this->paginate($this->Documents);

        $documentTypes = $this->Documents->DocumentTypes
            ->find();

        $this->set(compact('documents', 'documentTypes'));
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
            // this is skecth
            $conditions = [
                'Documents.id' => -1,
            ];
        }
        $this->paginate = [
            'contain' => [
                'DocumentTypes',
                'Users',
                'Files'
            ],
            'conditions' => $conditions,
        ];
        $documents = $this->paginate($this->Documents);

        $this->set(compact('documents'));
    }

    public function changeCover($id = null)
    {
        if ($this->hasRights($id)) {
            $document = $this->Documents->find('all', [
                'contain' => ['Files'],
                'conditions' => [
                    'Documents.id' => $id
                ]
            ])->first();
            if ($document) {
                $file = $this->Documents->Files->newEntity();
                if ($this->request->is('post') or $this->request->is('ajax')) {
                    $this->autoRender = false;
                    //debug($this->request->data);
                    //die();
                    if (!empty($this->request->data['file']['name'])) {
                        //debug($this->request->data);
                        //die();
                        $fileName = $this->request->data['file']['name'];
                        $uploadPath = 'Files/';
                        $uploadFile = $uploadPath . $fileName;
                        if (move_uploaded_file($this->request->data['file']['tmp_name'], 'img/' . $uploadFile)) {
                            //$file = $this->Files->patchEntity($file, $this->request->getData());
                            $file->name = $fileName;
                            $file->path = $uploadPath;
                            $file->status = 1;
                            if ($this->Documents->Files->save($file)) {

                                $document->document_cover = $file['id'];

                                if ($this->Documents->save($document)) {
                                    
                                    $this->Flash->success(__('File has been uploaded and inserted successfully.'));

                                }

                            } else {
                                $this->Flash->error(__('Unable to upload file, please try again.'));
                            }
                        } else {
                            $this->Flash->error(__('Unable to upload file, please try again.'));
                        }
                    } else {
                        $this->Flash->error(__('Please choose a file to upload.'));
                    }
                }
            }
        }
        $this->set(compact('id'));
    }

    public function search()
    {

        $term = $this->request->query['search_term'];

        if ($term != null) {
            
            // TODO make it multilingual by searching for their value in i18n
            $documents_query = $this->Documents->find('all', array(
                'conditions' => array('Documents.name LIKE ' => '%' . $term . '%')
            ));

            $this->paginate = [
                'contain' => ['DocumentTypes', 'Users', 'Files'],
                'conditions' => [
                    'Documents.published' => 1,
                    'Documents.deleted' => 0,
                    'Documents.name LIKE ' => '%' . $term . '%'
                ],
            ];

            $documents = $this->paginate($this->Documents);

        } else {
            return $this->redirect(['controller' => 'pages', 'action' => 'myhome']);
        }

        $this->set(compact('documents'));
    
    }

    public function hasRights($doc_id=null)
    {
        $has_rights = false;
        if ($doc_id) {
            $user = $this->Auth->user();
            if ($user) {
                if ($user['role']['role'] == 'admin') {
                    $has_rights = true;
                } elseif ($user['role']['role'] == 'creator') {
                    if ($user['verified']) {
                        $doc = $this->Documents->find('all', [
                            'conditions' => [
                                'Documents.id' => $doc_id,
                                'Documents.user_id' => $user['id']
                            ]
                        ])->first();
                        if ($doc) {
                            $has_rights = true;
                        }
                    } else {
                        if ($this->request->getParam('action') != 'view') {
                            $this->Flash->error(__('You\'re account is not verified.'));
                        }
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

            $doc = $this->Documents->get($doc_id);

            if($doc['deleted'] == false) {
                if ($doc['published'] == true) {
                    $has_rights = true;
                } else {
                    $user = $this->Auth->user();
                    if ($user) {
                        
                        switch ($user['role']['role']) {
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

        $can_view = false;
        $session = $this->getRequest()->getSession();

        $viewed_docs = $session->read('viewed_docs');

        if (!$viewed_docs) {
            $viewed_docs = array($doc_id);
            $session->write('viewed_docs', $viewed_docs);
            $can_view = true;
        } else {
            if (!in_array($doc_id, $viewed_docs)) {
                array_push($viewed_docs, $doc_id);
                $session->write('viewed_docs', $viewed_docs);
                $can_view = true;
            }
        }
        
        if ($can_view) {
            # code...
            $user = $this->Auth->user();

            if ($user) {
                $user_id = $this->Auth->user()['id'];
            } else {
                $visitor_id = $this->Documents->Users->find('all', [
                    'contain' => 'Roles',
                    'conditions' => [
                        'Roles.role' => 'visitor'
                    ]
                ])->first()['id'];
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

    public function findDocuments()
    {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $term = $this->request->query['term'];
            // TODO make it multilingual by searching for their value in i18n
            $results = $this->Documents->find('all', array(
                'conditions' => array(
                    'Documents.name LIKE ' => '%' . $term . '%',
                    'Documents.published' => 1,
                    'Documents.deleted' => 0,
                )
            ));
            $resultArr = array();
            foreach ($results as $result) {
                $resultArr[] = array('label' => $result['name'], 'value' => $result['name']);
            }
            echo json_encode($resultArr);
        } else {
            return $this->redirect(['controller' => 'Pages', 'action' => 'myhome']);
        }
    }

    public function getRegions()
    {
        $country_id = $this->request->query('country_id');

        $regions = $this->Documents->Regions->find('all', [
            'conditions' => [
                'Regions.country_id' => $country_id,
                'Regions.name !=' => ''
            ],
        ]);

        $this->set('regions', $regions);
        $this->set('_serialize', ['regions']);
    }

}
