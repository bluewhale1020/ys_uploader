<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MimeTypesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MimeTypesTable Test Case
 */
class MimeTypesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MimeTypesTable
     */
    public $MimeTypes;

    /**
     * Fixtures
     *
     * @var array
     */
    // public $fixtures = [
        // 'app.mime_types'
    // ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->MimeTypes = TableRegistry::get('MimeTypes');
        // $config = TableRegistry::getTableLocator()->exists('MimeTypes') ? [] : ['className' => MimeTypesTable::class];
        // $this->MimeTypes = TableRegistry::getTableLocator()->get('MimeTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MimeTypes);

        parent::tearDown();
    }

    /**
     * Test testCreateAllowedAmbiguousMimeArray method
     *
     * @return void
     */
    public function testCreateAllowedAmbiguousMimeArray()
    {
        $param = "";
        
        $result = $this->MimeTypes->createAllowedAmbiguousMimeArray();
        
        $expected = [
        'application/vnd.ms-office'
    ];
        
        debug($result);
        $this->assertEquals($expected, $result);
    }
    /**
     * Test testCreateAllowedMimeArray method
     *
     * @return void
     */
    public function testCreateAllowedMimeArray()
    {

        $param = "";
        
        $result = $this->MimeTypes->createAllowedMimeArray();
        
        $expected =     [
                              'image/jpeg' => 'jpg',                     // images
                              'image/pjpeg' => 'pjpeg', 
                              'image/png' => 'png', 
                              'image/gif' => 'gif', 
                              'image/tiff' => 'tiff', 
                              'image/x-tiff' => 'tiff', 

                              'application/pdf' => 'pdf',                // pdf
                              'application/x-pdf' => 'pdf', 
                              'application/acrobat' => 'acrobat', 
                              'text/pdf' => 'pdf',
                              'text/x-pdf' => 'pdf', 

                              'text/plain' => 'txt',                     // text
                              
                              'application/msword' => 'doc',             // word
                              'application/vnd.openxmlformats-officedocument.wordprocessingml.document'=> 'docx',
                              'application/mspowerpoint' => 'ppt',       // powerpoint
                              'application/powerpoint' => 'ppt',
                              'application/vnd.ms-powerpoint' => 'ppt',
                              'application/x-mspowerpoint' => 'ppt',
                              'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
                              'application/x-msexcel' => 'xls',          // excel
                              'application/excel' => 'xls',
                              'application/x-excel' => 'xls',
                              'application/vnd.ms-excel' => 'xls',                              
                              'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'=>'xlsx',
                              'application/vnd.ms-access' => 'mdb',
                              'application/x-msaccess'=>'mdb',

                              'application/x-compressed' => 'zip',       // compressed files
                              'application/x-zip-compressed' => 'zip',
                              'application/zip' => 'zip',
                              'multipart/x-zip' => 'zip',
                              'application/x-tar' => 'tar',
                              'application/x-compressed' => 'zip',
                              'application/x-gzip' => 'gzip',
                              'application/x-gzip' => 'gzip',
                              'multipart/x-gzip' => 'gzip'
                       ];
        
        debug($result);
        $this->assertEquals($expected, $result);

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
