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

use \Reshi\Constraints\IsLessThan;

class IsLessThanTest extends PHPUnit_Framework_TestCase
{
    protected $isLessThan;

    protected function setUp()
    {
        $this->isLessThan = new IsLessThan(10); 
    }
    public function testEvaluate()
    {        
        $this->assertTrue($this->isLessThan->evaluate(5), "Failed to assert that '5' is less than '10'");
        $this->assertFalse($this->isLessThan->evaluate(10), "Failed to assert that '10' is less than '10'");
        $this->assertFalse($this->isLessThan->evaluate(15), "Failed to assert that '15' is less than '10'");        
    }

    public function testGetName()
    {
        $this->assertEquals($this->isLessThan->getName(), "IS_LESS_THAN", "Failed to assert LESS_THAN is the constraint name.");
    }
}
