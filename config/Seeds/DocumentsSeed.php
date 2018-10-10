<?php
use Migrations\AbstractSeed;

/**
 * Documents seed.
 */
class DocumentsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'type_id' => '1',
                'user_id' => '3',
                'document_cover' => '2',
                'name' => 'Frogs',
                'description' => NULL,
                'other_details' => NULL,
                'published' => '1',
                'deleted' => '0',
                'created' => NULL,
                'modified' => NULL,
            ],
            [
                'id' => '2',
                'type_id' => '1',
                'user_id' => '4',
                'document_cover' => '3',
                'name' => 'Trees',
                'description' => NULL,
                'other_details' => NULL,
                'published' => '1',
                'deleted' => '0',
                'created' => NULL,
                'modified' => NULL,
            ],
        ];

        $table = $this->table('documents');
        $table->insert($data)->save();
    }
}
