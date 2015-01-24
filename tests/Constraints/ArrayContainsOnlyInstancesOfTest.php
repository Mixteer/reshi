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

use Reshi\Constraints\ArrayContainsOnlyInstancesOf;

class ArrayContainsOnlyInstancesOfTest extends PHPUnit_Framework_TestCase
{
    protected $arrayContainsOnlyInstancesOf;
    
    public function testEvaluate()
    {
        $this->arrayContainsOnlyInstancesOf = new ArrayContainsOnlyInstancesOf('StdClass');
        $this->assertTrue($this->arrayContainsOnlyInstancesOf->evaluate(array(new StdClass, new StdClass, new StdClass)), "Failed to assert that the array contains only the given type");    
        $this->assertFalse($this->arrayContainsOnlyInstancesOf->evaluate(array(new Exception, new StdClass, new StdClass)), "Failed to assert that the array does not contains only the given type");    
    }

    public function testGetName()
    {
        $this->arrayContainsOnlyInstancesOf = new ArrayContainsOnlyInstancesOf('bool');
        $this->assertEquals($this->arrayContainsOnlyInstancesOf->getName(), "CONTAINS_ONLY_INSTANCES_OF", "Failed to assert CONTAINS is the constraint name.");
    }
}
