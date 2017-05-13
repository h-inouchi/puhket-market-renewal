<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\IkuyoCommentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\IkuyoCommentsTable Test Case
 */
class IkuyoCommentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\IkuyoCommentsTable
     */
    public $IkuyoComments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ikuyo_comments',
        'app.comedy_live_shows',
        'app.live_show_titles',
        'app.places',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('IkuyoComments') ? [] : ['className' => 'App\Model\Table\IkuyoCommentsTable'];
        $this->IkuyoComments = TableRegistry::get('IkuyoComments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->IkuyoComments);

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
