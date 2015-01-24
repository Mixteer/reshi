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

use \Reshi\Constraints\ObjectHasAttribute;
use \Reshi\Constraints\IsInstanceOf;
use \Reshi\Constraints\IsTrue;

class ObjectHasAttributeTest extends PHPUnit_Framework_TestCase
{
    protected $objectHasAttribute;

    public function setUp()
    {
        $this->objectHasAttribute = new ObjectHasAttribute('name');
    }
    
    public function testEvaluateWithCorrectParameters()
    {        
        $this->assertTrue($this->objectHasAttribute->evaluate(new ObjectHasAttributeTestClass), "Failed to assert that the object has the given attribute");
    }
    
    public function testEvaluateWithIncorrectParameters()
    {
        $this->objectHasAttribute = new ObjectHasAttribute('age');
        $this->assertFalse($this->objectHasAttribute->evaluate(new ObjectHasAttributeTestClass), "Failed to assert that the object has the given attribute");
    }

    public function testGetName()
    {
        $this->assertEquals($this->objectHasAttribute->getName(), "OBJECT_HAS_ATTRIBUTE", "Failed to assert OBJECT_HAS_ATTRIBUTE is the constraint name.");
    }
}

class ObjectHasAttributeTestClass
{
    protected $name;
}
