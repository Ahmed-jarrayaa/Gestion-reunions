<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Notifications Model
 *
 * @property \App\Model\Table\UtilisateursTable&\Cake\ORM\Association\BelongsTo $Utilisateurs
 * @property \App\Model\Table\ReunionsTable&\Cake\ORM\Association\BelongsTo $Reunions
 *
 * @method \App\Model\Entity\Notification newEmptyEntity()
 * @method \App\Model\Entity\Notification newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Notification[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Notification get($primaryKey, $options = [])
 * @method \App\Model\Entity\Notification findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Notification patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Notification[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Notification|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notification saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notification[]|false saveMany($entities, $options = [])
 */
class NotificationsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('notifications');
        $this->setDisplayField('message');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                ],
            ],
        ]);

        $this->belongsTo('Utilisateurs', [
            'foreignKey' => 'utilisateur_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Reunions', [
            'foreignKey' => 'id_reunion',
            'joinType' => 'LEFT',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('message')
            ->allowEmptyString('message');

        $validator
            ->boolean('lu')
            ->allowEmptyString('lu');

        $validator
            ->boolean('supprime')
            ->allowEmptyString('supprime');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('utilisateur_id', 'Utilisateurs'), ['errorField' => 'utilisateur_id']);

        return $rules;
    }
}