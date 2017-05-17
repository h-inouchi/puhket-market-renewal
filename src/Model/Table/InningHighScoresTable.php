<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InningHighScores Model
 *
 * @method \App\Model\Entity\InningHighScore get($primaryKey, $options = [])
 * @method \App\Model\Entity\InningHighScore newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\InningHighScore[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InningHighScore|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InningHighScore patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InningHighScore[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\InningHighScore findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InningHighScoresTable extends Table
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

        $this->setTable('inning_high_scores');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
    }
    public $validate = [
        'player_name' => [
            'notEmpty' => [
                'rule' => 'notBlank',
                'required' => true,
                'message' => '名前を入力してください。',
            ],
            'maxLength' => [
                'rule' => ['maxLength', 25],
                'message' => '名前を２５字以内で入力してください。',
            ]
        ],
    ];

    public function getTop10($gameName = "") {
        return $this->find('all', [
            'fields' => [
                'player_name',
                'high_score'
            ],
            'conditions' => [
                'high_score BETWEEN ? AND ?' => [1, 100],
                'game_name' => $gameName,
            ],
            'order' => ['high_score' => 'DESC'],
            'limit' => 10,
        ]);
    }

    public function findGetTop10(Query $query, array $options)
    {
        $gameName = $options['gameName'];
        $query->select([
            'player_name',
            'high_score'
        ]);
        $query->where([
            'game_name' => $gameName,
        ]);
        $query->where(function ($exp, $q) {
            return $exp->between('high_score', 1, 100);
        });
        $query->order([
            'high_score' => 'DESC'
        ]);
        $query->limit(
            10
        );
        return $query;
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
            ->integer('high_score')
            ->requirePresence('high_score', 'create')
            ->notEmpty('high_score');

        $validator
            ->requirePresence('player_name', 'create')
            ->notEmpty('player_name');

        $validator
            ->requirePresence('game_name', 'create')
            ->notEmpty('game_name');

        return $validator;
    }
}
