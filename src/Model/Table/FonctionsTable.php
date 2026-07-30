<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Fonctions Model
 *
 * @property \App\Model\Table\UtilisateursTable&\Cake\ORM\Association\HasMany $Utilisateurs
 *
 * @method \App\Model\Entity\Fonction newEmptyEntity()
 * @method \App\Model\Entity\Fonction newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Fonction> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Fonction get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Fonction findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Fonction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Fonction> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Fonction|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Fonction saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Fonction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Fonction>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Fonction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Fonction> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Fonction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Fonction>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Fonction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Fonction> deleteManyOrFail(iterable $entities, array $options = [])
 */
class FonctionsTable extends Table
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

        $this->setTable('fonctions');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->hasMany('Utilisateurs', [
            'foreignKey' => 'fonction_id',
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

        return $validator;
    }
}
