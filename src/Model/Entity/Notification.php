<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Notification Entity
 *
 * @property int $id
 * @property int|null $utilisateur_id
 * @property string|null $message
 * @property int|null $id_reunion
 * @property string|null $type
 * @property bool|null $lu
 * @property bool|null $supprime
 * @property \Cake\I18n\DateTime|null $send_at
 * @property \Cake\I18n\DateTime|null $created
 * @property \App\Model\Entity\Utilisateur|null $utilisateur
 * @property \App\Model\Entity\Reunion|null $reunion
 */
class Notification extends Entity
{
    /**
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'utilisateur_id' => true,
        'message' => true,
        'id_reunion' => true,
        'type' => true,
        'lu' => true,
        'supprime' => true,
        'send_at' => true,
        'created' => true,
        'utilisateur' => true,
        'reunion' => true,
    ];
}