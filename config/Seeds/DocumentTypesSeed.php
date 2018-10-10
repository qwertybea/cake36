<?php
use Migrations\AbstractSeed;

/**
 * DocumentTypes seed.
 */
class DocumentTypesSeed extends AbstractSeed
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
                'type' => 'text',
            ],
        ];

        $table = $this->table('document_types');
        $table->insert($data)->save();
    }
}
