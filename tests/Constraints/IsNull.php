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

use \Reshi\Constraints\IsNull;

class IsNotNullTest extends PHPUnit_Framework_TestCase
{
    protected $isNull;

    protected function setUp()
    {
        $this->isNull = new IsNull;
    }

    public function testEvaluate()
    {
        $this->assertTrue($this->isNull->evaluate(NULL), "Failed to assert that NULL as input is NULL.");
        $this->assertFalse($this->isNull->evaluate(TRUE), "Failed to assert that TRUE as input is not NULL.");
        $this->assertFalse($this->isNull->evaluate(TRUE), "Failed to assert that TRUE as input is not NULL.");
        $this->assertFalse($this->isNull->evaluate('hello'), "Failed to assert that a STRING as input is not NULL.");
        $this->assertFalse($this->isNull->evaluate(0), "Failed to assert that an INTEGER as input is not NULL.");
    }

    public function testGetName()
    {
        $this->assertEquals($this->isNull->getName(), "IS__NULL", "Failed to assert IS_NULL is the constraint name.");
    }
}
