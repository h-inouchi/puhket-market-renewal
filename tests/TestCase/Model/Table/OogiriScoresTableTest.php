<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OogiriScoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OogiriScoresTable Test Case
 */
class OogiriScoresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OogiriScoresTable
     */
    public $OogiriScores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.oogiri_scores'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('OogiriScores') ? [] : ['className' => 'App\Model\Table\OogiriScoresTable'];
        $this->OogiriScores = TableRegistry::get('OogiriScores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OogiriScores);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
