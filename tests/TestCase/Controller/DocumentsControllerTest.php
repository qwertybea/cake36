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
    public $documentsController;
    
    public function setUp()
    {
        parent::setUp();

        $usersTable = TableRegistry::get('users');

        $this->authAdmin = [
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'admin',
                    'email' => 'admin@admin.com',
                    'verified' => true,
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
                    'verified' => true,
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

        $this->documentsController = new DocumentsController();
    }

    public function tearDown()
    {
        unset($this->authAdmin);
        unset($this->authCreator);
        unset($this->authVisitor);
        unset($this->documentsController);
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
        'app.interactions',
        'app.interactive_methods',
        'app.text_documents',
        'app.countries',
        'app.regions',
        'core.translates'
    ];

    // /**
    //  * Test initialize method
    //  *
    //  * @return void
    //  */
    // public function testInitialize()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test beforeFilter method
    //  *
    //  * @return void
    //  */
    // public function testBeforeFilter()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->session($this->authAdmin);
        $this->get('/documents');
        $this->assertResponseContains('Les documents');
        // echo $this->_response->getBody();
        $this->assertResponseOk();
    }

    // /**
    //  * Test viewAllDocuments method
    //  *
    //  * @return void
    //  */
    // public function testViewAllDocumentsAsNotAdmin()
    // {
    //     $this->session($this->authCreator);
    //     $this->get('/documents/view-all-documents');
    //     // $this->assertResponseContains('You are not authorized to access that location.');
    //     $this->assertRedirect(['controller' => null, 'action' => null]);
    // }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->session($this->authAdmin);
        $this->get('/documents/view/1');
        $this->assertResponseContains('document 1');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->session($this->authAdmin);
        $this->get('/documents/add/1');

        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'Documents', 'action' => 'edit', 4]);

    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->session($this->authAdmin);
        $this->get('/documents/edit/1');
        $this->assertResponseOk();
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->session($this->authAdmin);
        $this->get('/documents/my-work');
        $this->assertResponseOk();
        $this->get('/documents/delete/1');
        $this->assertResponseSuccess();
    }

    public function testAdminNonPosAuth()
    {
        $this->session($this->authAdmin);
        $this->get('/documents/edit/1');
        $this->assertResponseContains('document 1');
        $this->assertResponseOk();
    }

    public function testVisitorNonPosAuth()
    {
        $this->session($this->authVisitor);
        $this->get('/documents/edit/1');
        $this->assertRedirect(['controller' => 'users', 'action' => 'login', 'redirect' => '/documents/edit/1']);
    }

    // /**
    //  * Test myWork method
    //  *
    //  * @return void
    //  */
    // public function testMyWork()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test myFavorites method
    //  *
    //  * @return void
    //  */
    // public function testMyFavorites()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test search method
    //  *
    //  * @return void
    //  */
    // public function testSearch()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test hasRights method
    //  *
    //  * @return void
    //  */
    // public function testHasRights()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test canView method
    //  *
    //  * @return void
    //  */
    // public function testCanView()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test handleViewInteraction method
    //  *
    //  * @return void
    //  */
    // public function testHandleViewInteraction()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test handleFavorite method
    //  *
    //  * @return void
    //  */
    // public function testHandleFavorite()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test findDocuments method
    //  *
    //  * @return void
    //  */
    // public function testFindDocuments()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    // /**
    //  * Test getRegions method
    //  *
    //  * @return void
    //  */
    // public function testGetRegions()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }
}
