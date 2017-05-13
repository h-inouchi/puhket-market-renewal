<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PersonalSchedulesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PersonalSchedulesTable Test Case
 */
class PersonalSchedulesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PersonalSchedulesTable
     */
    public $PersonalSchedules;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.personal_schedules',
        'app.live_show_titles',
        'app.users',
        'app.comedy_live_shows',
        'app.places',
        'app.ikuyo_comments',
        'app.unit_members'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('PersonalSchedules') ? [] : ['className' => 'App\Model\Table\PersonalSchedulesTable'];
        $this->PersonalSchedules = TableRegistry::get('PersonalSchedules', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PersonalSchedules);

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
