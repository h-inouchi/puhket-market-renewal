<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\YoutubeUrlsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\YoutubeUrlsTable Test Case
 */
class YoutubeUrlsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\YoutubeUrlsTable
     */
    public $YoutubeUrls;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.youtube_urls',
        'app.users',
        'app.units',
        'app.blog_posts',
        'app.comedy_live_shows',
        'app.live_show_titles',
        'app.ikuyo_comments',
        'app.personal_schedules',
        'app.places',
        'app.unit_members',
        'app.images',
        'app.oogiri_answers',
        'app.posts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('YoutubeUrls') ? [] : ['className' => 'App\Model\Table\YoutubeUrlsTable'];
        $this->YoutubeUrls = TableRegistry::get('YoutubeUrls', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->YoutubeUrls);

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
