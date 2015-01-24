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

use \Reshi\Constraints\Equals;

class EqualsTest extends PHPUnit_Framework_TestCase
{
    protected $equals;

    /**
     * @dataProvider arrayProvider
     */
    public function testEvaluate($paramOne, $paramTwo)
    {
        $this->equals = new Equals($paramTwo);
        $this->assertTrue($this->equals->evaluate($paramOne), "Failed to assert that the array is of the expected size");
    }

    public function testEvaluateWithWrongData()
    {
        $this->equals = new Equals(null);
        $this->assertFalse($this->equals->evaluate("hello"), "Failed to assert that 'null' is not equal to 'hello'");   
    }

    public function arrayProvider()
    {
        return array(
            array(0, 0),
            array(1.0, 1.0),
            array("hello", "hello"),
            array(TRUE, TRUE),
            array(FALSE, FALSE),
            array(NULL, NULL),
            array(new StdClass, new StdClass),
        );
    }

    public function testGetName()
    {
        $this->equals = new Equals(0);
        $this->assertEquals($this->equals->getName(), "EQUALS", "Failed to assert COUNT is the constraint name.");
    }
}
