<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PlanificationTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PlanificationTable Test Case
 */
class PlanificationTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PlanificationTable
     */
    protected $Planification;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Planification',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Planification') ? [] : ['className' => PlanificationTable::class];
        $this->Planification = $this->getTableLocator()->get('Planification', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Planification);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PlanificationTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
