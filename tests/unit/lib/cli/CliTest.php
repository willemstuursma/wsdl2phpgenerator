<?php
/**
 * @package cliTest
 */

/**
 * Test class for Cli.
 * @package cliTest
 * Generated by PHPUnit on 2010-01-20 at 21:39:33.
 */
class CliTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Cli
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Cli('Test', 'test', '1.0');
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * Tests the exception when adding the same flag again
     */
    public function testAddFlag()
    {
        $this->object->addFlag('-f', 'test', true, true);
        $this->setExpectedException('Exception');
        $this->object->addFlag('-f', 'test', true, false);
    }

    /**
     * Tests the exception when adding a flag that already is a alias
     */
    public function testAddFlag2()
    {
        $this->object->addFlag('-f', 'test', true, true);
        $this->object->addAlias('-f', '--bar');
        $this->object->addAlias('-f', '--foo');
        $this->setExpectedException('Exception');
        $this->object->addFlag('--foo', 'test', true, false);
    }

    /**
     * Tests the exception raised when adding duplicate aliases
     */
    public function testAddAlias()
    {
        $this->object->addFlag('-f', 'test', true, true);
        $this->object->addAlias('-f', '--bar');
        $this->object->addAlias('-f', '--foo');
        $this->setExpectedException('Exception');
        $this->object->addAlias('-f', '--foo');
    }

    /**
     * Tests the exception when assigning alias to nonexisting flag
     */
    public function testAddAlias2()
    {
        $this->object->addFlag('-f', 'test', true, true);
        $this->object->addAlias('-f', '--foo');
        $this->object->addAlias('-f', '--bar');
        $this->setExpectedException('Exception');
        $this->object->addAlias('-q', '--foo');
    }

    /**
     *
     */
    public function testValidate()
    {
        $this->object->addFlag('-f', 'test', true, true);
        $this->object->addAlias('-f', '--foo');
        $this->object->validate(array('--foo'));
    }

    /**
     * Tests the whole getValue function, implicitly tests the getFlag function too
     */
    public function testGetValue()
    {
        $this->object->addFlag('-f', 'test', true, true);
        $this->object->addFlag('-g', 'test', true, false);
        $this->object->addAlias('-f', '--bar');
        $this->object->validate(array('-f=foo', '--bar', 'foo'));
        $this->assertEquals('foo', $this->object->getValue('-f'));
        $this->assertEquals('foo', $this->object->getValue('--bar'));
        $this->assertEquals(false, $this->object->getValue('-g'));
        $this->assertEquals(false, $this->object->getValue('--invalidFlag'));
        $this->assertNotEquals(false, $this->object->getValue('-f'));
    }
}
