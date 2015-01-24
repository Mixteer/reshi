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

use \Reshi\Constraints\IsGreaterThanOrEqualTo;

class IsGreaterThanOrEqualToTest extends PHPUnit_Framework_TestCase
{
    protected $isGreaterThanOrEqualTo;

    protected function setUp()
    {
        $this->isGreaterThanOrEqualTo = new IsGreaterThanOrEqualTo(10); 
    }

    public function testEvaluate()
    {        
        $this->assertTrue($this->isGreaterThanOrEqualTo->evaluate(20), "Failed to assert that the argument passed: '20' is greater than or equal to '10' ");
        $this->assertTrue($this->isGreaterThanOrEqualTo->evaluate(10), "Failed to assert that the argument passed: '10' is greater than or equal to '15'");
        $this->assertFalse($this->isGreaterThanOrEqualTo->evaluate(5), "Failed to assert that the argument passed: '10' is greater than or equal to '10'");
    }

    public function testGetName()
    {
        $this->assertEquals($this->isGreaterThanOrEqualTo->getName(), "IS_GREATER_THAN_OR_EQUAL_TO", "Failed to assert GREATER_THAN_OR_EQUAL_TO is the constraint name.");
    }
}
