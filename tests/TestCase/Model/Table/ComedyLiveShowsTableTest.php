<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ComedyLiveShowsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ComedyLiveShowsTable Test Case
 */
class ComedyLiveShowsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ComedyLiveShowsTable
     */
    public $ComedyLiveShows;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.comedy_live_shows',
        'app.places',
        'app.live_show_titles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ComedyLiveShows') ? [] : ['className' => 'App\Model\Table\ComedyLiveShowsTable'];
        $this->ComedyLiveShows = TableRegistry::get('ComedyLiveShows', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ComedyLiveShows);

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
}
