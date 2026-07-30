<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FonctionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FonctionsTable Test Case
 */
class FonctionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FonctionsTable
     */
    protected $Fonctions;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Fonctions',
        'app.Utilisateurs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Fonctions') ? [] : ['className' => FonctionsTable::class];
        $this->Fonctions = $this->getTableLocator()->get('Fonctions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Fonctions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\FonctionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
