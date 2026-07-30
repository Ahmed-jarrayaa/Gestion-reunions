<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Utilisateurs Model
 *
 * @method \App\Model\Entity\Utilisateur newEmptyEntity()
 * @method \App\Model\Entity\Utilisateur newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Utilisateur> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Utilisateur get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Utilisateur findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Utilisateur patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Utilisateur> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Utilisateur|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Utilisateur saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Utilisateur>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Utilisateur>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Utilisateur>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Utilisateur> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Utilisateur>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Utilisateur>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Utilisateur>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Utilisateur> deleteManyOrFail(iterable $entities, array $options = [])
 */
use Authentication\PasswordHasher\DefaultPasswordHasher;
class UtilisateursTable extends Table
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

        $this->setTable('utilisateurs');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');
           $this->belongsTo('Fonctions', [
        'foreignKey' => 'fonction_id',
        'joinType' => 'LEFT',
    ]);

  
$this->belongsToMany('Reunions', [
    'joinTable' => 'participants',
    'foreignKey' => 'id_utilisateur',
    'targetForeignKey' => 'id_reunion',
]);

$this->belongsToMany('Planification', [
    'through' => 'ParticipantsPlanifications',
    'foreignKey' => 'id_utilisateur',
    'targetForeignKey' => 'id_planification',
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
            ->scalar('nom')
            ->maxLength('nom', 100)
            ->requirePresence('nom', 'create')
            ->notEmptyString('nom');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('role')
            ->allowEmptyString('role');

        $validator
            ->scalar('mot_de_passe')
            ->maxLength('mot_de_passe', 255)
            ->requirePresence('mot_de_passe', 'create')
            ->notEmptyString('mot_de_passe');

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
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }
    public function beforeSave($event, $entity, $options)
{
    if ($entity->isDirty('mot_de_passe')) {
        $entity->mot_de_passe = (new DefaultPasswordHasher())->hash($entity->mot_de_passe);
    }
}
}