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

use Reshi\Constraints\EndsWith;

class EndsWithTest extends PHPUnit_Framework_TestCase
{
    protected $endsWith;
    
    protected function setUp()
    {
        $this->endsWith = new EndsWith('lo');   
    }

    public function testEvaluate()
    {
        $this->assertTrue($this->endsWith->evaluate('hello'), "Failed to assert that 'hello' ends with : 'lo'");
        $this->assertFalse($this->endsWith->evaluate('hella'), "Failed to assert that 'hella' doesnt end with : 'lo'");
        $this->assertFalse($this->endsWith->evaluate('hellol'), "Failed to assert that 'hellol' doesnt end with : 'lo'");
        $this->assertFalse($this->endsWith->evaluate(''), "Failed to assert that '' doesnt end with : 'lo'");
        $this->assertFalse($this->endsWith->evaluate(NULL), "Failed to assert that 'NULL' doesnt end with : 'lo'");
    }

    public function testGetName()
    {
        $this->assertEquals($this->endsWith->getName(), "ENDS_WITH", "Failed to assert ENDS_WITH is the constraint name.");
    }
}
