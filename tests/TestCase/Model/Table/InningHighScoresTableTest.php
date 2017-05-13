<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InningHighScoresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InningHighScoresTable Test Case
 */
class InningHighScoresTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InningHighScoresTable
     */
    public $InningHighScores;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.inning_high_scores'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('InningHighScores') ? [] : ['className' => 'App\Model\Table\InningHighScoresTable'];
        $this->InningHighScores = TableRegistry::get('InningHighScores', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->InningHighScores);

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
