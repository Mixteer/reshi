
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

use \Reshi\Constraints\IsGreaterThan;

class IsGreaterThanTest extends PHPUnit_Framework_TestCase
{
    protected $isGreaterThan;

    protected function setUp()
    {
        $this->isGreaterThan = new IsGreaterThan(10);   
    }
    
    public function testEvaluate()
    {        
        $this->assertTrue($this->isGreaterThan->evaluate(20), "Failed to assert that '20' is greater than : '10'");
        $this->assertFalse($this->isGreaterThan->evaluate(10), "Failed to assert that '10' is not greater than : '10'");
        $this->assertFalse($this->isGreaterThan->evaluate(5), "Failed to assert that '5' is not greater than : '10'");
    }

    public function testGetName()
    {
        $this->assertEquals($this->isGreaterThan->getName(), "IS_GREATER_THAN", "Failed to assert GREATER_THAN is the constraint name.");
    }
}
