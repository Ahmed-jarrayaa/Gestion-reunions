<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ParticipantsFixture
 */
class ParticipantsFixture extends TestFixture
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
                'id_reunion' => 1,
                'id_utilisateur' => 1,
                'presence' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
