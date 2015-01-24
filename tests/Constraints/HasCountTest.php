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

use \Reshi\Constraints\HasCount;

class HasCountTest extends PHPUnit_Framework_TestCase
{
    protected $hasCount;

    protected function setUp()
    {
        $this->hasCount = new HasCount(3);
    }
    public function testEvaluate()
    {
        $this->assertTrue($this->hasCount->evaluate(array(1,2,3)), "Failed to assert that the array is of the expected size");
        $this->assertFalse($this->hasCount->evaluate(array(1)), "Failed to assert that the array is not of the expected size");
    }

    public function testGetName()
    {
        $this->assertEquals($this->hasCount->getName(), "HAS_COUNT", "Failed to assert COUNT is the constraint name.");
    }
}
