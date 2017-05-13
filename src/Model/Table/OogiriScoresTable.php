<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OogiriScores Model
 *
 * @method \App\Model\Entity\OogiriScore get($primaryKey, $options = [])
 * @method \App\Model\Entity\OogiriScore newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OogiriScore[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OogiriScore|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OogiriScore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OogiriScore[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OogiriScore findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OogiriScoresTable extends Table
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

        $this->setTable('oogiri_scores');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->integer('score')
            ->allowEmpty('score');

        $validator
            ->allowEmpty('uuid');

        return $validator;
    }
}
