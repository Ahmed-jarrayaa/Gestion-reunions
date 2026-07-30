<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ParticipantsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('participants');
        $this->setPrimaryKey('id');

        // Relation vers la table Reunions
        $this->belongsTo('Reunions', [
            'foreignKey' => 'id_reunion',
            'joinType' => 'INNER',
        ]);

        // Relation vers la table Utilisateurs
        $this->belongsTo('Utilisateurs', [
            'foreignKey' => 'id_utilisateur',
            'joinType' => 'INNER',
        ]);
   


}

    // src/Model/Table/ParticipantsTable.php
public function validationDefault(Validator $validator): Validator
{
    $validator
        ->integer('id')
        ->allowEmptyString('id', null, 'create');

    $validator
        ->integer('id_utilisateur')
        ->requirePresence('id_utilisateur', 'create')
        ->notEmptyString('id_utilisateur', 'L\'utilisateur est requis.');

    $validator
        ->integer('id_reunion')
        ->requirePresence('id_reunion', 'create')
        ->notEmptyString('id_reunion', 'La réunion est requise.');

    return $validator;
}


}
