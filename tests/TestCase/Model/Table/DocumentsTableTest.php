<?php
namespace App\Test\TestCase\Model\Table;
use App\Model\Table\DocumentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
/**
 * App\Model\Table\CarsTable Test Case
 */
class DocumentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentsTable
     */
    public $DocumentsTable;
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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Documents') ? [] : ['className' => DocumentsTable::class];
        $this->DocumentsTable = TableRegistry::getTableLocator()->get('Documents', $config);
    }
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->DocumentsTable);
        parent::tearDown();
    }


	public function testFindPublished()
    {
        $query = $this->Documents->find('published');
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->hydrate(false)->toArray();
        $expected = [
            [
                'id' => 1,
                'type_id' => 1,
                'user_id' => 1,
                'document_cover' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'other_details' => 'Lorem ipsum dolor sit amet',
                'published' => 1,
                'deleted' => 0,
                'created' => '2018-11-09 06:47:05',
                'modified' => '2018-11-09 06:47:05',
                'country_id' => 1,
                'region_id' => 1
            ],
            [
                'id' => 3,
                'type_id' => 1,
                'user_id' => 1,
                'document_cover' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'other_details' => 'Lorem ipsum dolor sit amet',
                'published' => 1,
                'deleted' => 1,
                'created' => '2018-11-09 06:47:05',
                'modified' => '2018-11-09 06:47:05',
                'country_id' => 1,
                'region_id' => 1
            ],
        ];
        $this->assertEquals($expected, $result);
    }


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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}