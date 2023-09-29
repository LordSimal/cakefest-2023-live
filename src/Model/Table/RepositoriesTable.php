<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Repositories Model
 *
 * @property \App\Model\Table\BranchesTable&\Cake\ORM\Association\HasMany $Branches
 * @method \App\Model\Entity\Repository newEmptyEntity()
 * @method \App\Model\Entity\Repository newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Repository[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Repository get($primaryKey, $options = [])
 * @method \App\Model\Entity\Repository findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Repository patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Repository[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Repository|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Repository saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Repository[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Repository[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Repository[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Repository[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RepositoriesTable extends Table
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

        $this->setTable('repositories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Branches', [
            'foreignKey' => 'repository_id',
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
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('url')
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        $validator
            ->integer('forks')
            ->requirePresence('forks', 'create')
            ->notEmptyString('forks');

        $validator
            ->integer('open_issues')
            ->requirePresence('open_issues', 'create')
            ->notEmptyString('open_issues');

        $validator
            ->integer('external_ident')
            ->requirePresence('external_ident', 'create')
            ->notEmptyString('external_ident');

        return $validator;
    }
}
