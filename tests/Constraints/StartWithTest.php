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

use Reshi\Constraints\StartsWith;

class StartsWithTest extends PHPUnit_Framework_TestCase
{
    protected $startWith;
    
    protected function setUp()
    {
        $this->startWith = new StartsWith('he');    
    }

    public function testEvaluate()
    {
        $this->assertTrue($this->startWith->evaluate('hello'), "Failed to assert that 'hello' starts with : 'he'");
        $this->assertFalse($this->startWith->evaluate('hilla'), "Failed to assert that 'hilla' doesnt end with : 'he'");
        $this->assertFalse($this->startWith->evaluate('hhellol'), "Failed to assert that 'hhellol' doesnt end with : 'he'");
        $this->assertFalse($this->startWith->evaluate(''), "Failed to assert that '' doesnt end with : 'he'");
        $this->assertFalse($this->startWith->evaluate(NULL), "Failed to assert that 'NULL' doesnt end with : 'he'");
    }

    public function testGetName()
    {
        $this->assertEquals($this->startWith->getName(), "STARTS_WITH", "Failed to assert ENDS_WITH is the constraint name.");
    }
}
