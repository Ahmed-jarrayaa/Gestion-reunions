<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ParticipantsPlanifications Model
 *
 * @method \App\Model\Entity\ParticipantsPlanification newEmptyEntity()
 * @method \App\Model\Entity\ParticipantsPlanification newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ParticipantsPlanification> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ParticipantsPlanification get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ParticipantsPlanification findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ParticipantsPlanification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ParticipantsPlanification> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ParticipantsPlanification|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ParticipantsPlanification saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ParticipantsPlanification>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ParticipantsPlanification>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ParticipantsPlanification>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ParticipantsPlanification> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ParticipantsPlanification>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ParticipantsPlanification>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ParticipantsPlanification>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ParticipantsPlanification> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ParticipantsPlanificationsTable extends Table
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

        $this->setTable('participants_planifications'); // ⚡ nom exact BDD
        $this->setPrimaryKey('id');

           $this->belongsTo('Planification', [
            'className' => 'Planification',
            'foreignKey' => 'id_planification',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Utilisateurs', [
            'className' => 'Utilisateurs',
            'foreignKey' => 'id_utilisateur',
            'joinType' => 'INNER'
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
            ->integer('id_planification')
            ->requirePresence('id_planification', 'create')
            ->notEmptyString('id_planification');

        $validator
            ->integer('id_utilisateur')
            ->requirePresence('id_utilisateur', 'create')
            ->notEmptyString('id_utilisateur');

        $validator
            ->boolean('presence')
            ->allowEmptyString('presence');

        return $validator;
    }
}
