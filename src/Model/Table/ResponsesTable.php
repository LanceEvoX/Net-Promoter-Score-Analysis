<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Responses Model
 *
 * @property \App\Model\Table\FormsTable&\Cake\ORM\Association\BelongsTo $Forms
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\BelongsTo $Branches
 * @property \App\Model\Table\AnswersTable&\Cake\ORM\Association\HasMany $Answers
 * @property \App\Model\Table\FeedbackTable&\Cake\ORM\Association\HasMany $Feedback
 *
 * @method \App\Model\Entity\Response newEmptyEntity()
 * @method \App\Model\Entity\Response newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Response[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Response get($primaryKey, $options = [])
 * @method \App\Model\Entity\Response findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Response patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Response[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Response|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Response saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Response[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Response[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Response[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Response[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ResponsesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('responses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Forms', [
            'foreignKey' => 'form_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Branches', [
            'foreignKey' => 'branch_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Answers', [
            'foreignKey' => 'response_id',
        ]);
        $this->hasMany('Feedback', [
            'foreignKey' => 'response_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('form_id')
            ->notEmptyString('form_id');

        $validator
            ->integer('branch_id')
            ->notEmptyString('branch_id');

        $validator
            ->scalar('respondent_id')
            ->maxLength('respondent_id', 255)
            ->allowEmptyString('respondent_id');

        $validator
            ->scalar('firstname')
            ->maxLength('firstname', 255)
            ->allowEmptyString('firstname');

        $validator
            ->scalar('middlename')
            ->maxLength('middlename', 255)
            ->allowEmptyString('middlename');

        $validator
            ->scalar('lastname')
            ->maxLength('lastname', 255)
            ->allowEmptyString('lastname');

        $validator
            ->integer('age')
            ->allowEmptyString('age');

        $validator
            ->scalar('gender')
            ->maxLength('gender', 255)
            ->allowEmptyString('gender');

        $validator
            ->scalar('location')
            ->maxLength('location', 255)
            ->allowEmptyString('location');

        $validator
            ->date('visit_date')
            ->requirePresence('visit_date', 'create')
            ->notEmptyDate('visit_date');

        $validator
            ->time('visit_time')
            ->requirePresence('visit_time', 'create')
            ->notEmptyTime('visit_time');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('form_id', 'Forms'), ['errorField' => 'form_id']);
        $rules->add($rules->existsIn('branch_id', 'Branches'), ['errorField' => 'branch_id']);

        return $rules;
    }
}
