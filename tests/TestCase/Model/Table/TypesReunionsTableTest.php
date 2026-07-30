<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TypesReunionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TypesReunionsTable Test Case
 */
class TypesReunionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TypesReunionsTable
     */
    protected $TypesReunions;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.TypesReunions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TypesReunions') ? [] : ['className' => TypesReunionsTable::class];
        $this->TypesReunions = $this->getTableLocator()->get('TypesReunions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TypesReunions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\TypesReunionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
