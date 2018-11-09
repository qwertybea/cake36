<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentsFixture
 *
 */
class DocumentsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'autoIncrement' => true, 'precision' => null, 'comment' => null],
        'type_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'precision' => null, 'comment' => null, 'autoIncrement' => null],
        'user_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'precision' => null, 'comment' => null, 'autoIncrement' => null],
        'document_cover' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'precision' => null, 'comment' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'precision' => null, 'comment' => null, 'fixed' => null, 'collate' => null],
        'description' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'precision' => null, 'comment' => null, 'fixed' => null, 'collate' => null],
        'other_details' => ['type' => 'string', 'length' => null, 'null' => true, 'default' => null, 'precision' => null, 'comment' => null, 'fixed' => null, 'collate' => null],
        'published' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'precision' => null, 'comment' => null],
        'deleted' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'precision' => null, 'comment' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'precision' => null, 'comment' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'precision' => null, 'comment' => null],
        'country_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => '33', 'precision' => null, 'comment' => null, 'autoIncrement' => null],
        'region_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => '496', 'precision' => null, 'comment' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'user_id_fk' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'document_cover_fk' => ['type' => 'foreign', 'columns' => ['document_cover'], 'references' => ['files', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'type_id_fk' => ['type' => 'foreign', 'columns' => ['type_id'], 'references' => ['document_types', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
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
        parent::init();
    }
}
