<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InvitationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InvitationsTable Test Case
 */
class InvitationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InvitationsTable
     */
    protected $Invitations;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Invitations',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Invitations') ? [] : ['className' => InvitationsTable::class];
        $this->Invitations = $this->getTableLocator()->get('Invitations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Invitations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\InvitationsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
