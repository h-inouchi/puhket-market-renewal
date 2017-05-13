<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PersonalSchedules Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LiveShowTitles
 * @property \Cake\ORM\Association\BelongsTo $Places
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $UnitMembers
 *
 * @method \App\Model\Entity\PersonalSchedule get($primaryKey, $options = [])
 * @method \App\Model\Entity\PersonalSchedule newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PersonalSchedule[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PersonalSchedule|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PersonalSchedule patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PersonalSchedule[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PersonalSchedule findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PersonalSchedulesTable extends Table
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

        $this->setTable('personal_schedules');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('LiveShowTitles', [
            'foreignKey' => 'live_show_title_id'
        ]);
        $this->belongsTo('Places', [
            'foreignKey' => 'place_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('UnitMembers', [
            'foreignKey' => 'unit_member_id'
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
            ->requirePresence('schedule_date', 'create')
            ->notEmpty('schedule_date');

        $validator
            ->requirePresence('schedule_title', 'create')
            ->notEmpty('schedule_title');

        $validator
            ->allowEmpty('schedule_detail');

        $validator
            ->allowEmpty('start_time');

        $validator
            ->allowEmpty('end_time');

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
        $rules->add($rules->existsIn(['live_show_title_id'], 'LiveShowTitles'));
        $rules->add($rules->existsIn(['place_id'], 'Places'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['unit_member_id'], 'UnitMembers'));

        return $rules;
    }
}
