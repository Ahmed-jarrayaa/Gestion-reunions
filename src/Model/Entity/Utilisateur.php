<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Utilisateur Entity
 *
 * @property int $id
 * @property string $nom
 * @property string $email
 * @property string|null $role
 * @property string $mot_de_passe
 * @property int|null $fonction_id
 * @property \App\Model\Entity\Reunion[] $reunions
 */
class Utilisateur extends Entity
{
    /**
     * Champs pouvant être assignés en masse.
     *
     * Note : `role` est volontairement exclus de l'assignation de masse afin
     * d'empêcher une élévation de privilège. Le rôle est défini uniquement par
     * le code (inscription -> 'membre', administration -> contrôleur).
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'id' => false,
        'nom' => true,
        'prenom' => true,
        'email' => true,
        'mot_de_passe' => true,
        'fonction_id' => true,
        'role' => false,
    ];

    /**
     * Champs masqués lors de l'export JSON / sérialisation.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'mot_de_passe',
    ];
}