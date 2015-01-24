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

use \Reshi\Constraints\IsLessThanOrEqualTo;

class IsLessThanOrEqualToTest extends PHPUnit_Framework_TestCase
{
    protected $isLessThanOrEqualTo;

    protected function setUp()
    {
        $this->isLessThanOrEqualTo = new IsLessThanOrEqualTo(10);
    }

    public function testEvaluate()
    {
        $this->assertTrue($this->isLessThanOrEqualTo->evaluate(5), "Failed to assert that '5' is less than '10'");
        $this->assertTrue($this->isLessThanOrEqualTo->evaluate(10), "Failed to assert that '5' is less than '10'");
        $this->assertFalse($this->isLessThanOrEqualTo->evaluate(20), "Failed to assert that '5' is less than '10'");
    }

    public function testGetName()
    {
        $this->assertEquals($this->isLessThanOrEqualTo->getName(), "IS_LESS_THAN_OR_EQUAL_TO", "Failed to assert LESS_THAN_OR_EQUAL_TO is the constraint name.");
    }
}
