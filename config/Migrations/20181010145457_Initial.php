<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('document_types')
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('documents')
            ->addColumn('type_id', 'integer', [
                'comment' => 'fk type_id',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'comment' => 'fk user_id',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('document_cover', 'integer', [
                'comment' => 'fk file_id',
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('other_details', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('published', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('deleted', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'document_cover',
                ]
            )
            ->addIndex(
                [
                    'type_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('email_verifications')
            ->addColumn('user_id', 'integer', [
                'comment' => 'fk user(id)',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('code', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('files')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('path', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('status', 'boolean', [
                'comment' => '1 = Active, 0 = Inactive',
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('i18n')
            ->addColumn('locale', 'string', [
                'default' => null,
                'limit' => 6,
                'null' => false,
            ])
            ->addColumn('model', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('foreign_key', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('field', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('content', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'locale',
                    'model',
                    'foreign_key',
                    'field',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'model',
                    'foreign_key',
                    'field',
                ]
            )
            ->create();

        $this->table('interactions')
            ->addColumn('document_id', 'integer', [
                'comment' => 'PF documents(id)',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'comment' => 'PF users(id)',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('interactiveMethod_id', 'integer', [
                'comment' => 'PF interactive_methods(id)',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'document_id',
                ]
            )
            ->addIndex(
                [
                    'interactiveMethod_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('interactive_methods')
            ->addColumn('method', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('text_documents')
            ->addColumn('document_id', 'integer', [
                'comment' => 'fk document_id',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('text', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'document_id',
                ]
            )
            ->create();

        $this->table('users')
            ->addColumn('role', 'string', [
                'comment' => 'fk Roles(role_code)',
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'comment' => 'Les mot de passes devraient être 123',
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('verified', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('documents')            ->addForeignKey(
                'document_cover',
                'files',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'RESTRICT'
                ]
            )
            ->addForeignKey(
                'type_id',
                'document_types',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('email_verifications')            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('interactions')            ->addForeignKey(
                'document_id',
                'documents',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'interactiveMethod_id',
                'interactive_methods',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('text_documents')            ->addForeignKey(
                'document_id',
                'documents',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();
    }

    public function down()
    {
        $this->table('documents')
            ->dropForeignKey(
                'document_cover'            )            ->dropForeignKey(
                'type_id'            )            ->dropForeignKey(
                'user_id'            )->save();
        $this->table('email_verifications')
            ->dropForeignKey(
                'user_id'            )->save();
        $this->table('interactions')
            ->dropForeignKey(
                'document_id'            )            ->dropForeignKey(
                'interactiveMethod_id'            )            ->dropForeignKey(
                'user_id'            )->save();
        $this->table('text_documents')
            ->dropForeignKey(
                'document_id'            )->save();
        $this->table('document_types')->drop()->save();
        $this->table('documents')->drop()->save();
        $this->table('email_verifications')->drop()->save();
        $this->table('files')->drop()->save();
        $this->table('i18n')->drop()->save();
        $this->table('interactions')->drop()->save();
        $this->table('interactive_methods')->drop()->save();
        $this->table('text_documents')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
