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

use \Reshi\Constraints\IsInstanceOf;
use \Reshi\Constraints\IsTrue;

class IsInstanceOfTest extends PHPUnit_Framework_TestCase
{
    protected $isInstanceOf;

    protected function setUp()
    {
        $this->isInstanceOf = new IsInstanceOf('TestClass'); 
    }
    
    public function testEvaluate()
    {
        $this->assertTrue($this->isInstanceOf->evaluate(new TestClass), "Failed to assert that the object is of the expected type ");
        $this->assertFalse($this->isInstanceOf->evaluate(new StdClass), "Failed to assert that the object is of not the expected type ");
    }

    public function testGetName()
    {
        $this->assertEquals($this->isInstanceOf->getName(), "IS_INSTANCE_OF", "Failed to assert INSTANCE_OF is the constraint name.");
    }
}

class TestClass
{
}