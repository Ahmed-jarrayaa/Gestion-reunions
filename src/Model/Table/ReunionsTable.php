<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Entity;
use Cake\Event\EventInterface;
use ArrayObject;
use Cake\Mailer\Mailer;

class ReunionsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('reunions');
        $this->setPrimaryKey('id');

        // Association avec Participants
        $this->hasMany('Participants', [
            'foreignKey' => 'id_reunion',
            'dependent' => true,
        ]);

        // Association avec TypesReunions
        $this->belongsTo('TypesReunions', [
            'foreignKey' => 'id_type',
            'joinType' => 'INNER',
        ]);

        // Association many-to-many avec Utilisateurs via Participants
        $this->belongsToMany('Utilisateurs', [
            'joinTable' => 'participants',
            'foreignKey' => 'id_reunion',
            'targetForeignKey' => 'id_utilisateur',
        ]);

        // Rendre participants_attente accessible pour patchEntity
        $this->getSchema()->setColumnType('participants_attente', 'json');
    }

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
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->dateTime('date_heure')
            ->requirePresence('date_heure', 'create')
            ->notEmptyDateTime('date_heure');

        $validator
            ->scalar('lieu')
            ->maxLength('lieu', 255)
            ->allowEmptyString('lieu');

        $validator
            ->scalar('statut')
            ->maxLength('statut', 50)
            ->allowEmptyString('statut');

        $validator
            ->integer('cree_par')
            ->requirePresence('cree_par', 'create')
            ->notEmptyString('cree_par');

        $validator
            ->integer('id_type')
            ->requirePresence('id_type', 'create')
            ->notEmptyString('id_type');

        // ✅ participants_attente : JSON stockant tableau d'IDs
        $validator
            ->allowEmptyString('participants_attente');

        return $validator;
    }

    public function beforeSave(EventInterface $event, Entity $entity, ArrayObject $options)
    {
        if (!$entity->isNew()) {
            $oldReunion = $this->get($entity->id);

            if ($oldReunion->date_heure != $entity->date_heure) {
                $this->notifyParticipantsDateChange($entity);
            }
        }
        return true;
    }

    protected function notifyParticipantsDateChange(Entity $reunion): void
    {
        $participantsTable = $this->getAssociation('Participants')->getTarget();

        $participants = $participantsTable->find()
            ->where(['id_reunion' => $reunion->id])
            ->contain(['Utilisateurs'])
            ->all();

        foreach ($participants as $participant) {
            $email = $participant->utilisateur->email ?? null;
            if ($email) {
                $mailer = new Mailer('default');
                $mailer->setTo($email)
                    ->setSubject('Modification de la date de la réunion')
                    ->setEmailFormat('text')
                    ->deliver(
                        "Bonjour,\nLa réunion '{$reunion->titre}' a changé de date. " .
                        "La nouvelle date est : {$reunion->date_heure}.\nMerci."
                    );
            }
        }
    }
}
