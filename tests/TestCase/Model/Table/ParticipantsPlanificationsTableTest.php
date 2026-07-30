<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParticipantsPlanificationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParticipantsPlanificationsTable Test Case
 */
class ParticipantsPlanificationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ParticipantsPlanificationsTable
     */
    protected $ParticipantsPlanifications;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ParticipantsPlanifications',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ParticipantsPlanifications') ? [] : ['className' => ParticipantsPlanificationsTable::class];
        $this->ParticipantsPlanifications = $this->getTableLocator()->get('ParticipantsPlanifications', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ParticipantsPlanifications);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ParticipantsPlanificationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
