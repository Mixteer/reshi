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

use Reshi\Constraints\FileExists;

class FileExistsTest extends PHPUnit_Framework_TestCase
{    
    protected $fileHandle = null;

    public function testEvaluate()
    {
        // First make sure the file exists and if it doesn't exist, create it
        $this->fileHandle = fopen(__DIR__.'/../../assets/file_one.txt', 'w') or die('Could not create file while setting up tests for FileExistsTest.');

        $fileExists = new FileExists(__DIR__.'/../../assets/file_one.txt');
        $this->assertTrue($fileExists->evaluate(), "Failed to assert that the given file exists");
    }

    public function testEvaluateWrongCase()
    {
        $fileExists = new FileExists(__DIR__.'/../../assets/file_doenst_exist.txt');
        $this->assertFalse($fileExists->evaluate(), "Failed to assert that the given file exists");
    }
    
    public function testGetName()
    {
        $fileExists = new FileExists(__DIR__.'/../../assets/file_one.txt');
        $this->assertEquals($fileExists->getName(), "FILE_EXISTS", "Failed to assert FILE_EXISTS is the constraint name.");
    }

    public function tearDown()
    {
        if ($this->fileHandle != null) {
            fclose($this->fileHandle);
            unlink(__DIR__.'/../../assets/file_one.txt');
        }
    }
}
