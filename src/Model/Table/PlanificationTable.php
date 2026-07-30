<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Planification Model
 *
 * @method \App\Model\Entity\Planification newEmptyEntity()
 * @method \App\Model\Entity\Planification newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Planification> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Planification get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Planification findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Planification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Planification> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Planification|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Planification saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Planification>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Planification>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Planification>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Planification> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Planification>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Planification>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Planification>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Planification> deleteManyOrFail(iterable $entities, array $options = [])
 */
class PlanificationTable extends Table
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

        $this->setTable('planification'); // ⚡ Nom exact en BDD
        $this->setPrimaryKey('id');
        $this->setDisplayField('titre');

        // Association avec participants_planifications
          $this->hasMany('ParticipantsPlanifications', [
            'className' => 'ParticipantsPlanifications',
            'foreignKey' => 'id_planification',
            'dependent' => true,
            'cascadeCallbacks' => true
          ]);
        


        // Association avec types_reunions
$this->belongsToMany('Utilisateurs', [
    'className' => 'Utilisateurs',
    'through' => 'ParticipantsPlanifications', // ⚡ sans underscore
    'foreignKey' => 'id_planification',
    'targetForeignKey' => 'id_utilisateur',
]);


        $this->belongsTo('TypesReunions', [
            'className' => 'TypesReunions',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('titre')
            ->maxLength('titre', 255)
            ->requirePresence('titre', 'create')
            ->notEmptyString('titre');

        $validator
            ->dateTime('date_planification')
            ->requirePresence('date_planification', 'create')
            ->notEmptyDateTime('date_planification');

        $validator
            ->scalar('lieu')
            ->maxLength('lieu', 255)
            ->requirePresence('lieu', 'create')
            ->notEmptyString('lieu');
        $validator
            ->scalar('statut')
            ->maxLength('statut', 20)
            ->allowEmptyString('statut');

        $validator
            ->integer('cree_par')
            ->requirePresence('cree_par', 'create')
            ->notEmptyString('cree_par');

        $validator
            ->integer('id_type')
            ->requirePresence('id_type', 'create')
            ->notEmptyString('id_type');

        return $validator;
        
    }
}
