<?php
use Migrations\AbstractSeed;

/**
 * Files seed.
 */
class FilesSeed extends AbstractSeed
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
                'name' => '',
                'path' => '',
                'created' => NULL,
                'modified' => NULL,
                'status' => '0',
            ],
            [
                'id' => '2',
                'name' => 'frog.jpg',
                'path' => 'Files/',
                'created' => NULL,
                'modified' => NULL,
                'status' => '1',
            ],
            [
                'id' => '3',
                'name' => 'trees.jpg',
                'path' => 'Files/',
                'created' => NULL,
                'modified' => NULL,
                'status' => '1',
            ],
        ];

        $table = $this->table('files');
        $table->insert($data)->save();
    }
}
