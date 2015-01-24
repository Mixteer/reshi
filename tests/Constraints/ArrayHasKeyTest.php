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

use Reshi\Constraints\ArrayHasKey;

class ArrayHasKeyTest extends PHPUnit_Framework_TestCase
{
    protected $arrayHasKey;
    
    protected function setUp()
    {
        $this->arrayHasKey = new ArrayHasKey('foo');
    }

    public function testEvaluate()
    {
        $this->assertTrue($this->arrayHasKey->evaluate(array('foo' => 'baz')), "Failed to assert that the array has the given key");
        $this->assertFalse($this->arrayHasKey->evaluate(array('bar' => 'baz')), "Failed to assert that the array has not the given key");
        $this->assertFalse($this->arrayHasKey->evaluate(array('FOO' => 'baz')), "Failed to assert that the array has not the given key");
        $this->assertFalse($this->arrayHasKey->evaluate(array('' => 'baz')), "Failed to assert that the array has not the given key");
    }

    public function testGetName()
    {
        $this->assertEquals($this->arrayHasKey->getName(), "ARRAY_HAS_KEY", "Failed to assert ARRAY_HAS_KEY is the constraint name.");
    }
}
