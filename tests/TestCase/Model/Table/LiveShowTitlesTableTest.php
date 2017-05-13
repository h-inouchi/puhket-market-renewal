<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LiveShowTitlesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LiveShowTitlesTable Test Case
 */
class LiveShowTitlesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LiveShowTitlesTable
     */
    public $LiveShowTitles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.live_show_titles',
        'app.users',
        'app.comedy_live_shows',
        'app.places',
        'app.ikuyo_comments',
        'app.personal_schedules'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LiveShowTitles') ? [] : ['className' => 'App\Model\Table\LiveShowTitlesTable'];
        $this->LiveShowTitles = TableRegistry::get('LiveShowTitles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LiveShowTitles);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
