<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ComedyLiveShows Model
 *
 * @property \Cake\ORM\Association\BelongsTo $LiveShowTitles
 * @property \Cake\ORM\Association\BelongsTo $Places
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $IkuyoComments
 *
 * @method \App\Model\Entity\ComedyLiveShow get($primaryKey, $options = [])
 * @method \App\Model\Entity\ComedyLiveShow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ComedyLiveShow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ComedyLiveShow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ComedyLiveShow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ComedyLiveShow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ComedyLiveShow findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ComedyLiveShowsTable extends Table
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

        $this->setTable('comedy_live_shows');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('LiveShowTitles', [
            'foreignKey' => 'live_show_title_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Places', [
            'foreignKey' => 'place_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('IkuyoComments', [
            'foreignKey' => 'comedy_live_show_id'
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
            ->allowEmpty('live_show_date');

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

        return $rules;
    }
}
