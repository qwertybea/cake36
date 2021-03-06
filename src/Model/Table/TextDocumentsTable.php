<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TextDocuments Model
 *
 * @method \App\Model\Entity\TextDocument get($primaryKey, $options = [])
 * @method \App\Model\Entity\TextDocument newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TextDocument[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TextDocument|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TextDocument|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TextDocument patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TextDocument[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TextDocument findOrCreate($search, callable $callback = null, $options = [])
 */
class TextDocumentsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('text_documents');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');


        // $this->addBehavior('Translate', ['fields' => ['text']]);

        $this->belongsTo('Documents', [
            'foreignKey' => 'document_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('text')
            ->allowEmpty('text');

        return $validator;
    }
}
