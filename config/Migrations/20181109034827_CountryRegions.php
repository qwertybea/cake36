<?php
use Migrations\AbstractMigration;

class CountryRegions extends AbstractMigration
{

    public $autoId = false;

    public function up()
    {

        $this->table('countries')
            ->addColumn('id', 'integer', [
                'default' => null,
                'limit' => 5,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('code', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addIndex(
                [
                    'name',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('regions')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('code', 'string', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('country_id', 'integer', [
                'default' => null,
                'limit' => 5,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'country_id',
                    'name',
                ]
            )
            ->create();
    }

    public function down()
    {
        $this->table('countries')->drop()->save();
        $this->table('regions')->drop()->save();
    }
}
