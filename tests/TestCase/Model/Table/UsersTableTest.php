<?php
namespace App\Test\TestCase\Model\Table;
use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
/**
 * App\Model\Table\CarsTable Test Case
 */
class UsersTableTest extends TestCase
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
        'app.users',
    ];
    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Users') ? [] : ['className' => UsersTable::class];
        $this->Users = TableRegistry::getTableLocator()->get('Users', $config);
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

    public function testValidateEmailSuccess () {
        $user = $this->Users->find('all')->first()->toArray();
        $errors = $this->Users->validationDefault(new Validator())->errors($user);
        $this->assertTrue(empty($errors['email']));
    }

    public function testValidateEmailFail () {
        $user = $this->Users->find('all')->first()->toArray();
        $user['email'] = '@mail.ca';
        $errors = $this->Users->validationDefault(new Validator())->errors($user);
        $this->assertTrue(!empty($errors['email']));
    }

}