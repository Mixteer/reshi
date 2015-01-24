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
 * WTFPL LICENSE
 */

use Reshi\Constraints\IsType;

class IsTypeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider typeProvider
     */
    public function testEvaluate($value, $type)
    {
        $isType = new IsType($type);

        $this->assertTrue($isType->evaluate($value), "Failed to assert that the given value is of type '". $isType->getName() ."'");
    }

    /**
     * @expectedException Exception
     */
    public function testEvaluateWithException()
    {
        $isType = new IsType('scalar');

        $this->assertTrue($isType->evaluate(null), "Failed to assert that the given value is of type '". $isType->getName() ."'");
    }

    public function typeProvider()
    {
        return array(
            array(TRUE, 'bool'),
            array(1, 'int'),
            array(1.5, 'float'),
            array("hello", 'string'),
            array(array(), 'array'),
            array(new StdClass, 'object'),
            array(tmpfile(), 'resource'),
            array(NULL, 'null'),
            array(function(){}, 'callable')
        );
    }

    /**
     * @dataProvider typeNameProvider
     */
    public function testGetName($value, $type, $typeName)
    {
        $isType = new IsType($type);
        $isType->evaluate($value);
        $this->assertEquals($isType->getName(), $typeName, "Failed to assert $typeName is the constraint name for $type");
    }

    public function typeNameProvider()
    {
        return array(
            array(TRUE, 'bool', 'IS_BOOL'),
            array(1, 'int', 'IS_INT'),
            array(1.5, 'float', 'IS_FLOAT'),
            array("hello", 'string', 'IS_STRING'),
            array(array(), 'array', 'IS_ARRAY'),
            array(new StdClass, 'object', 'IS_OBJECT'),
            array(NULL, 'resource', 'IS_RESOURCE'),
            array(function(){}, 'callable', 'IS_CALLABLE')
        );
    }
}
