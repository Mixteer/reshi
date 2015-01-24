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

use \Reshi\Constraints\IsFalse;

class IsFalseTest extends PHPUnit_Framework_TestCase
{
    protected $isFalse;

    protected function setUp()
    {
        $this->isFalse = new IsFalse;
    }

    public function testEvaluate()
    {
        $this->assertTrue($this->isFalse->evaluate(FALSE), "Failed to assert that FALSE as input is false.");
        $this->assertFalse($this->isFalse->evaluate(TRUE), "Failed to assert that TRUE as input is not false.");
        $this->assertFalse($this->isFalse->evaluate("FALSE"), "Failed to assert that string FALSE as input is not false as boolean");   
        $this->assertFalse($this->isFalse->evaluate(NULL), "Failed to assert that NULL as input is not false as boolean");
    }

    public function testGetName()
    {
        $this->assertEquals($this->isFalse->getName(), "IS_FALSE", "Failed to assert IS_FALSE is the constraint name.");
    }
}
