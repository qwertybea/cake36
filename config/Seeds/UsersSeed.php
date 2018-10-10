<?php
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
                'role' => 'visitor',
                'username' => '',
                'email' => '',
                'password' => '',
                'verified' => '0',
                'created' => NULL,
                'modified' => NULL,
            ],
            [
                'id' => '2',
                'role' => 'admin',
                'username' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$10$ONneUhzLKfpWoiKMeFi0au7/wxcqV/6CyTsAzCAWDF.XkdWqGMkRm',
                'verified' => '1',
                'created' => NULL,
                'modified' => NULL,
            ],
            [
                'id' => '3',
                'role' => 'creator',
                'username' => 'wikipedia',
                'email' => 'wiki@gmail.com',
                'password' => '$2y$10$ONneUhzLKfpWoiKMeFi0au7/wxcqV/6CyTsAzCAWDF.XkdWqGMkRm',
                'verified' => '1',
                'created' => NULL,
                'modified' => NULL,
            ],
            [
                'id' => '4',
                'role' => 'creator',
                'username' => 'Joyce_Kilmer',
                'email' => 'JK@gmail.com',
                'password' => '$2y$10$ONneUhzLKfpWoiKMeFi0au7/wxcqV/6CyTsAzCAWDF.XkdWqGMkRm',
                'verified' => '1',
                'created' => NULL,
                'modified' => NULL,
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
