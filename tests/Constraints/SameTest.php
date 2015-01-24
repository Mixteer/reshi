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

use \Reshi\Constraints\Same;

class SameTest extends PHPUnit_Framework_TestCase
{
    protected $same;

    /**
     * @dataProvider arrayProvider
     */
    public function testEvaluate($paramOne, $paramTwo)
    {
        $this->same = new Same($paramTwo);
        $this->assertTrue($this->same->evaluate($paramOne), "Failed to assert that the array is of the expected size");
    }

    public function testEvaluateWithWrongData()
    {
        $this->same = new Same(null);
        $this->assertFalse($this->same->evaluate("hello"), "Failed to assert that 'null' is not equal to 'hello'"); 
    }

    public function testEvaluateEdgeCase()
    {
        $this->same = new Same('TRUE');
        $this->assertFalse($this->same->evaluate(TRUE), "Failed to assert that 'TRUE'(string) is not equal to 'TRUE'(bool)");    
    }

    public function arrayProvider()
    {
        $object = new StdClass;

        return array(
            array(0, 0),
            array(1.0, 1.0),
            array("hello", "hello"),
            array(TRUE, TRUE),
            array(FALSE, FALSE),
            array(NULL, NULL),
            array($object, $object),
        );
    }

    public function testGetName()
    {
        $this->same = new Same(0);
        $this->assertSame($this->same->getName(), "SAME", "Failed to assert SAME is the constraint name.");
    }
}
