<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\FileHandlerComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\FileHandlerComponent Test Case
 */
class FileHandlerComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\FileHandlerComponent
     */
    public $FileHandler;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->FileHandler = new FileHandlerComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FileHandler);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
