<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RepositoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RepositoriesTable Test Case
 */
class RepositoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RepositoriesTable
     */
    protected $Repositories;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Repositories',
        'app.Branches',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Repositories') ? [] : ['className' => RepositoriesTable::class];
        $this->Repositories = $this->getTableLocator()->get('Repositories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Repositories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RepositoriesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
