<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Branches Model
 *
 * @property \App\Model\Table\FeedbackTable&\Cake\ORM\Association\HasMany $Feedback
 * @property \App\Model\Table\ResponsesTable&\Cake\ORM\Association\HasMany $Responses
 * @property \App\Model\Table\UserBranchesTable&\Cake\ORM\Association\HasMany $UserBranches
 *
 * @method \App\Model\Entity\Branch newEmptyEntity()
 * @method \App\Model\Entity\Branch newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Branch[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Branch get($primaryKey, $options = [])
 * @method \App\Model\Entity\Branch findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Branch patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Branch[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Branch|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Branch saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Branch[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class BranchesTable extends Table
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

        $this->setTable('branches');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Feedback', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('Responses', [
            'foreignKey' => 'branch_id',
        ]);
        $this->hasMany('UserBranches', [
            'foreignKey' => 'branch_id',
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
            ->integer('shortcode')
            ->allowEmptyString('shortcode')
            ->add('shortcode', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('b_category')
            ->notEmptyString('b_category');

        $validator
            ->scalar('b_prefix')
            ->maxLength('b_prefix', 255)
            ->allowEmptyString('b_prefix');

        $validator
            ->integer('hmn')
            ->notEmptyString('hmn');

        $validator
            ->scalar('address')
            ->maxLength('address', 16777215)
            ->allowEmptyString('address');

        $validator
            ->dateTime('trashed')
            ->allowEmptyDateTime('trashed');

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
        $rules->add($rules->isUnique(['shortcode'], ['allowMultipleNulls' => true]), ['errorField' => 'shortcode']);

        return $rules;
    }
}
