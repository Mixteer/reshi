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

use \Reshi\Constraints\EqualsFile;

class EqualsFileTest extends PHPUnit_Framework_TestCase
{
    protected $equalsFile;
    protected $fileHandle = null;

    public function setUp()
    {
        $this->fileHandle = fopen(__DIR__.'/../../assets/file_one.txt', 'w') or die('Could not create file while setting up tests for EqualsFileTest.');
        fwrite($this->fileHandle, "a");

        $this->equalsFile = new EqualsFile(__DIR__.'/../../assets/file_one.txt');
    }

    public function testEvaluate()
    {
        $this->assertTrue($this->equalsFile->evaluate('a'), "Failed to assert that the file content is 'a'");
        $this->assertFalse($this->equalsFile->evaluate('b'), "Failed to assert that the file content is not 'b'");
    }

    public function testGetName()
    {
        $this->assertEquals($this->equalsFile->getName(), "EQUALS_FILE", "Failed to assert EQUALS_FILE is the constraint name.");
    }

    public function tearDown()
    {
        if ($this->fileHandle != null) {
            fclose($this->fileHandle);
            unlink(__DIR__.'/../../assets/file_one.txt');
        }
    }
}
