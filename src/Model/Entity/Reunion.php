<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reunion Entity
 *
 * @property int $id
 * @property string $titre
 * @property string|null $description
 * @property \Cake\I18n\DateTime $date_heure
 * @property string|null $lieu
 * @property string|null $statut
 * @property int|null $cree_par
 * @property int|null $id_type
 */
class Reunion extends Entity
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
        'description' => true,
        'date_heure' => true,
        'lieu' => true,
        'statut' => true,
        'cree_par' => true,
        'id_type' => true,
    ];
}
