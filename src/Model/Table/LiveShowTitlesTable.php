<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LiveShowTitles Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $ComedyLiveShows
 * @property \Cake\ORM\Association\HasMany $IkuyoComments
 * @property \Cake\ORM\Association\HasMany $PersonalSchedules
 *
 * @method \App\Model\Entity\LiveShowTitle get($primaryKey, $options = [])
 * @method \App\Model\Entity\LiveShowTitle newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LiveShowTitle[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LiveShowTitle|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LiveShowTitle patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LiveShowTitle[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LiveShowTitle findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LiveShowTitlesTable extends Table
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

        $this->setTable('live_show_titles');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('ComedyLiveShows', [
            'foreignKey' => 'live_show_title_id'
        ]);
        $this->hasMany('IkuyoComments', [
            'foreignKey' => 'live_show_title_id'
        ]);
        $this->hasMany('PersonalSchedules', [
            'foreignKey' => 'live_show_title_id'
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
            ->allowEmpty('title');

        $validator
            ->allowEmpty('detail');

        $validator
            ->allowEmpty('open');

        $validator
            ->allowEmpty('start');

        $validator
            ->allowEmpty('fee');

        $validator
            ->allowEmpty('iri');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
