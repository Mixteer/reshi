<?php
/**
 * Reshi libray - an assertion library.
 *
 * @author      Armando Sudi <armando.sudi@mixteer.com>
 * @copyright   2015 Mixteer
 * @link        http://os.mixteer.com/baseutils/reshi
 * @license     http://os.mixteer.com/baseutils/reshi/license
 * @version     0.1.0
 *
 * MIT LICENSE
 */

use Reshi\Constraints\ArrayContains;

class ArrayContainsTest extends PHPUnit_Framework_TestCase
{
    protected $arrayContains;
    
    protected function setUp()
    {
        $this->arrayContains = new ArrayContains('foo');
    }

    public function testEvaluate()
    {
        $this->assertTrue($this->arrayContains->evaluate(array('foo','baz')), "Failed to assert that the array has the given key");
        $this->assertFalse($this->arrayContains->evaluate(array('fooo','baz')), "Failed to assert that the array has not the given key");
        $this->assertFalse($this->arrayContains->evaluate(array('FOO','baz')), "Failed to assert that the array has not the given key");
        $this->assertFalse($this->arrayContains->evaluate(array('' => 'baz')), "Failed to assert that the array has not the given key");
    }

    public function testGetName()
    {
        $this->assertEquals($this->arrayContains->getName(), "CONTAINS", "Failed to assert CONTAINS is the constraint name.");
    }
}
