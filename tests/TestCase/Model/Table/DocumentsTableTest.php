<?php
namespace App\Test\TestCase\Model\Table;
use App\Model\Table\DocumentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
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
        $this->Documents = TableRegistry::getTableLocator()->get('Documents', $config);
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

	public function testFindNotDeleted()
    {
        $query = $this->Documents->find('NotDeleted');
        $this->assertInstanceOf('Cake\ORM\Query', $query);
        $result = $query->hydrate(false)->toArray();
        $expected = [
            [
                'id' => 1,
                'type_id' => 1,
                'user_id' => 1,
                'document_cover' => 1,
                'name' => 'document 1',
                'description' => 'Lorem ipsum dolor sit amet',
                'other_details' => 'Lorem ipsum dolor sit amet',
                'published' => 1,
                'deleted' => 0,
                'created' => null,
                'modified' => null,
                'country_id' => 1,
                'region_id' => 1
            ],
            [
                'id' => 2,
                'type_id' => 1,
                'user_id' => 2,
                'document_cover' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'other_details' => 'Lorem ipsum dolor sit amet',
                'published' => 0,
                'deleted' => 0,
                'created' => null,
                'modified' => null,
                'country_id' => 1,
                'region_id' => 1
            ],
        ];
        $this->assertEquals($expected, $result);
    }

    public function testSaveXSS() {
        $doc = $this->Documents->find('all')->first();
        $id = $doc->id;
        $doc->name = '<script>five = 2+2;</script>';
        $this->Documents->save($doc);
        $doc = $this->Documents->find('all', ['conditions' => ['id' => $id]])->first();
        $this->assertEquals('&lt;script&gt;five = 2+2;&lt;/script&gt;', $doc->name);
    }

    public function testSaving() {
        $data = [
            'id' => 4,
            'type_id' => 1,
            'user_id' => 1,
            'document_cover' => 1,
            'name' => 'document 4',
            'description' => 'Lorem ipsum dolor sit amet',
            'other_details' => 'Lorem ipsum dolor sit amet',
            'published' => 1,
            'deleted' => 0,
            'created' => null,
            'modified' => null,
            'country_id' => 1,
            'region_id' => 1
        ];
        $doc = $this->Documents->newEntity($data);
        $countBeforeSave = $this->Documents->find()->count();
        $this->Documents->save($doc);
        $countAfterSave = $this->Documents->find()->count();
        $this->assertEquals($countAfterSave, $countBeforeSave + 1);
    }

    public function testEditing() {
        $doc = $this->Documents->find('all', ['conditions' => ['published' => true]])->first();
        $id = $doc->id;
        $doc->published = false;
        $this->Documents->save($doc);
        $doc = $this->Documents->find('all', ['conditions' => ['id' => $id]])->first();
        $this->assertEquals(false, $doc->published);
    }

    public function testDeleting() {
        $doc = $this->Documents->find('all', ['conditions' => ['deleted' => false]])->first();
        $id = $doc->id;
        $doc->deleted = true;
        $this->Documents->save($doc);
        $doc = $this->Documents->find('all', ['conditions' => ['id' => $id]])->first();
        $this->assertEquals(true, $doc->deleted);
    }


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
    //  * Test validationDefault method
    //  *
    //  * @return void
    //  */
    // public function testValidationDefault()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }
    // /**
    //  * Test buildRules method
    //  *
    //  * @return void
    //  */
    // public function testBuildRules()
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }
}