<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PlanificationFixture
 */
class PlanificationFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'planification';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'titre' => 'Lorem ipsum dolor sit amet',
                'date_planification' => '2025-08-21 10:25:48',
                'lieu' => 'Lorem ipsum dolor sit amet',
                'cree_par' => 1,
                'id_type' => 1,
            ],
        ];
        parent::init();
    }
}
