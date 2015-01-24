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

use \Reshi\Constraints\IsTrue;

class IsTrueTest extends PHPUnit_Framework_TestCase
{
    protected $isTrue;

    protected function setUp()
    {
        $this->isTrue = new IsTrue;
    }

    public function testEvaluate()
    {
        $this->assertTrue($this->isTrue->evaluate(TRUE), "Failed to assert that TRUE as input is true.");
        $this->assertFalse($this->isTrue->evaluate(FALSE), "Failed to assert that FALSE as input is not true.");
        $this->assertFalse($this->isTrue->evaluate(NULL), "Failed to assert that NULL as input is not true.");
        $this->assertFalse($this->isTrue->evaluate("TRUE"), "Failed to assert that TRUE as a string is not TRUE as a boolean. Strict comparison not use.");
    }

    public function testGetName()
    {
        $this->assertEquals($this->isTrue->getName(), "IS_TRUE", "Failed to assert IS_TRUE is the constraint name.");
    }
}
