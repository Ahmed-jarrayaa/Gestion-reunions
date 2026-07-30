<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ParticipantsPlanificationsFixture
 */
class ParticipantsPlanificationsFixture extends TestFixture
{
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
                'id_planification' => 1,
                'id_utilisateur' => 1,
                'presence' => 1,
            ],
        ];
        parent::init();
    }
}
