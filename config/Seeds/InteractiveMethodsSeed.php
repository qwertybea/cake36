<?php
use Migrations\AbstractSeed;

/**
 * InteractiveMethods seed.
 */
class InteractiveMethodsSeed extends AbstractSeed
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
                'method' => 'view',
            ],
            [
                'id' => '2',
                'method' => 'like',
            ],
            [
                'id' => '3',
                'method' => 'dislike',
            ],
            [
                'id' => '4',
                'method' => 'favorite',
            ],
        ];

        $table = $this->table('interactive_methods');
        $table->insert($data)->save();
    }
}
