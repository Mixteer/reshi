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

use \Reshi\Constraints\IsEmpty;

class IsEmptyTest extends PHPUnit_Framework_TestCase
{
    protected $isEmpty;

    protected function setUp()
    {
        $this->isEmpty = new IsEmpty;
    }

    public function testEvaluate()
    {
        $this->assertTrue($this->isEmpty->evaluate(array()), "Failed to assert that the array is empty");
        $this->assertFalse($this->isEmpty->evaluate(array("hello")), "Failed to assert that an non-empty array is not empty");
    }

    public function testGetName()
    {
        $this->assertEquals($this->isEmpty->getName(), "IS_EMPTY", "Failed to assert EMPTY is the constraint name.");
    }
}
