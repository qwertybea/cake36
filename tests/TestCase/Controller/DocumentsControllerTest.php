<?php
namespace App\Test\TestCase\Controller;

use App\Controller\DocumentsController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\DocumentsController Test Case
 */
class DocumentsControllerTest extends IntegrationTestCase
{

    public $authAdmin;
    public $authCreator;
    public $authVisitor;
    
    public function setUp()
    {
        parent::setUp();

        $usersTable = TableRegistry::get('users');
        // $admin = $usersTable->find('all', [
        //     'contain' => ['roles'],
        //     'conditions' => [
        //         'Roles.role' => 'admin'
        //     ]
        // ])->first()->toArray();
        // $creator = $usersTable->find('all', [
        //     'contain' => ['roles'],
        //     'conditions' => [
        //         'Roles.role' => 'creator'
        //     ]
        // ])->first()->toArray();
        // $this->authAdmin = [
        //     'Auth' => [
        //         'User' => $admin
        //     ]
        // ];
        // $this->authCreator = [
        //     'Auth' => [
        //         'User' => $creator
        //     ]
        // ];

        $this->authAdmin = [
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'admin',
                    'email' => 'admin@admin.com',
                    'role' => [
                        'role' => 'admin',
                    ],
                ]
            ]
        ];
        $this->authCreator = [
            'Auth' => [
                'User' => [
                    'id' => 2,
                    'username' => 'creator',
                    'email' => 'creator@creator.com',
                    'role' => [
                        'role' => 'creator',
                    ],
                ]
            ]
        ];
        $this->authVisitor = [
            'Auth' => [
            ]
        ];
    }

    public function tearDown()
    {
        unset($this->authAdmin);
        unset($this->authCreator);
        unset($this->authVisitor);
        parent::tearDown();
    }

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.documents',
        'app.document_types',
        'app.users',
        'app.roles',
        'app.files',
        'app.i18n',
        'app.interactions',
        'app.text_documents',
        'app.countries',
        'app.regions'
    ];

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test beforeFilter method
     *
     * @return void
     */
    public function testBeforeFilter()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->session($this->authAdmin);
        $this->get('/documents');
        // $this->assertResponseContains('Story city');
        // echo $this->_response->getBody();
        $this->assertResponseOk();
    }

    /**
     * Test viewAllDocuments method
     *
     * @return void
     */
    public function testViewAllDocumentsAsNotAdmin()
    {
        $this->session($this->authCreator);
        $this->get('/documents/view-all-documents');
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login', 'redirect' => '/documents/view-all-documents']);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test myWork method
     *
     * @return void
     */
    public function testMyWork()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test myFavorites method
     *
     * @return void
     */
    public function testMyFavorites()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test search method
     *
     * @return void
     */
    public function testSearch()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test hasRights method
     *
     * @return void
     */
    public function testHasRights()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test canView method
     *
     * @return void
     */
    public function testCanView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test handleViewInteraction method
     *
     * @return void
     */
    public function testHandleViewInteraction()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test handleFavorite method
     *
     * @return void
     */
    public function testHandleFavorite()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test findDocuments method
     *
     * @return void
     */
    public function testFindDocuments()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getRegions method
     *
     * @return void
     */
    public function testGetRegions()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
