<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReunionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReunionsTable Test Case
 */
class ReunionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReunionsTable
     */
    protected $Reunions;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Reunions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Reunions') ? [] : ['className' => ReunionsTable::class];
        $this->Reunions = $this->getTableLocator()->get('Reunions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Reunions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ReunionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
