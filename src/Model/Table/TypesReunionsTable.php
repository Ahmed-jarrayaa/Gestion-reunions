<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TypesReunions Model
 *
 * @method \App\Model\Entity\TypesReunion newEmptyEntity()
 * @method \App\Model\Entity\TypesReunion newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\TypesReunion> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TypesReunion get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\TypesReunion findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\TypesReunion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\TypesReunion> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TypesReunion|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\TypesReunion saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\TypesReunion>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TypesReunion>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TypesReunion>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TypesReunion> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TypesReunion>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TypesReunion>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TypesReunion>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TypesReunion> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TypesReunionsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('types_reunions');
        $this->setDisplayField('nom_type');
        $this->setPrimaryKey('id');
        $this->hasMany('Reunions', [
    'foreignKey' => 'id_type',
]);
       $this->hasMany('Planification', [
    'foreignKey' => 'id_type',
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
            ->scalar('nom_type')
            ->maxLength('nom_type', 100)
            ->requirePresence('nom_type', 'create')
            ->notEmptyString('nom_type');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        return $validator;
    }
}
