<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

class Utilisateur extends Entity
{
    // DOIT être typé array pour correspondre à Cake\ORM\Entity
protected array $_accessible = [
        '*' => true, // permet de patcher tous les champs
        'id' => false,
    ];

    // DOIT être typé array
    protected array $_hidden = [
        'mot_de_pass',
    ];

    /**
     * S’appelle automatiquement quand on assigne $entity->mot_de_pass
     * Le nom du setter DOIT correspondre au champ : mot_de_pass -> _setMotDePass
     */
    protected function _setMotDePass(string $password): ?string
{
    if (strlen($password) > 0) {
        return (new DefaultPasswordHasher())->hash($password);
    }
    return null;
}

}
