<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UploadFilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UploadFilesTable Test Case
 */
class UploadFilesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UploadFilesTable
     */
    public $UploadFiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.upload_files'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UploadFiles') ? [] : ['className' => UploadFilesTable::class];
        $this->UploadFiles = TableRegistry::getTableLocator()->get('UploadFiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UploadFiles);

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
