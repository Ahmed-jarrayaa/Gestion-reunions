<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ParticipantsPlanification Entity
 *
 * @property int $id
 * @property int $id_planification
 * @property int $id_utilisateur
 * @property bool|null $presence
 */
class ParticipantsPlanification extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'id_planification' => true,
        'id_utilisateur' => true,
        'presence' => true,
    ];
}
