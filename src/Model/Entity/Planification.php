<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Planification Entity
 *
 * @property int $id
 * @property string $titre
 * @property \Cake\I18n\DateTime $date_planification
 * @property string $lieu
 * @property int $cree_par
 * @property int $id_type
 */
class Planification extends Entity
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
        'titre' => true,
        '*' => true,
    'id' => false,
        'date_planification' => true,
        'lieu' => true,
        'cree_par' => true,
        'id_type' => true,
        'participants_planifications' => true // ✅ important
    ];
}
