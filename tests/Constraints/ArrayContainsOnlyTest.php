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

use Reshi\Constraints\ArrayContainsOnly;

class ArrayContainsOnlyTest extends PHPUnit_Framework_TestCase
{
    protected $arrayContainsOnly;
    
    /**
     * @dataProvider typeProvider
     */
    public function testEvaluate($type, $actualArray)
    {
        $this->arrayContainsOnly = new ArrayContainsOnly($type);
        $this->assertTrue($this->arrayContainsOnly->evaluate($actualArray), "Failed to assert that the array has elements of the given type only.");  
    }

    public function testEvaluateWithIncorrectData()
    {
        $this->arrayContainsOnly = new ArrayContainsOnly('bool');
        $this->assertFalse($this->arrayContainsOnly->evaluate(array(true, false, 0)), "Failed to assert that the array does not have elements of the given type only.");
    }

    public function typeProvider()
    {
        $anArray = array(1,2,3);
        return array(
            array('bool', array(TRUE, FALSE)),
            array('int', array(10, 11, 12, 13)),
            array('float', array(20.5, 15.6, 148.62)),
            array('string', array('hello', 'world')),
            array('array', array($anArray)),
            array('object', array(new StdClass, new StdClass)),
            array('resource', array(tmpfile())),
            array('null', array(null))
        );
    }

    public function testGetName()
    {
        $this->arrayContainsOnly = new ArrayContainsOnly('bool');
        $this->assertTrue($this->arrayContainsOnly->evaluate(array(TRUE)), "Failed to assert that the array has the given type");
        $this->assertEquals($this->arrayContainsOnly->getName(), "CONTAINS_ONLY", "Failed to assert CONTAINS is the constraint name.");
    }
}
