<?php
use Migrations\AbstractSeed;

/**
 * Interactions seed.
 */
class InteractionsSeed extends AbstractSeed
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
                'document_id' => '2',
                'user_id' => '1',
                'interactiveMethod_id' => '1',
                'created' => NULL,
                'modified' => NULL,
            ],
            [
                'id' => '2',
                'document_id' => '2',
                'user_id' => '1',
                'interactiveMethod_id' => '1',
                'created' => NULL,
                'modified' => NULL,
            ],
            [
                'id' => '3',
                'document_id' => '2',
                'user_id' => '1',
                'interactiveMethod_id' => '1',
                'created' => NULL,
                'modified' => NULL,
            ],
            [
                'id' => '4',
                'document_id' => '2',
                'user_id' => '1',
                'interactiveMethod_id' => '1',
                'created' => NULL,
                'modified' => NULL,
            ],
            [
                'id' => '5',
                'document_id' => '2',
                'user_id' => '1',
                'interactiveMethod_id' => '1',
                'created' => NULL,
                'modified' => NULL,
            ],
            [
                'id' => '6',
                'document_id' => '2',
                'user_id' => '1',
                'interactiveMethod_id' => '1',
                'created' => NULL,
                'modified' => NULL,
            ],
        ];

        $table = $this->table('interactions');
        $table->insert($data)->save();
    }
}
