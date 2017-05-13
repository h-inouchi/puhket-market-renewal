<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IkuyoComments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ComedyLiveShows
 * @property \Cake\ORM\Association\BelongsTo $LiveShowTitles
 *
 * @method \App\Model\Entity\IkuyoComment get($primaryKey, $options = [])
 * @method \App\Model\Entity\IkuyoComment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IkuyoComment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IkuyoComment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IkuyoComment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IkuyoComment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IkuyoComment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IkuyoCommentsTable extends Table
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

        $this->setTable('ikuyo_comments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ComedyLiveShows', [
            'foreignKey' => 'comedy_live_show_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('LiveShowTitles', [
            'foreignKey' => 'live_show_title_id',
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
            ->allowEmpty('nick_name');

        $validator
            ->integer('ticket_count')
            ->allowEmpty('ticket_count');

        $validator
            ->allowEmpty('comment');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['comedy_live_show_id'], 'ComedyLiveShows'));
        $rules->add($rules->existsIn(['live_show_title_id'], 'LiveShowTitles'));

        return $rules;
    }
}
