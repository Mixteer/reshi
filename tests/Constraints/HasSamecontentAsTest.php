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

use \Reshi\Constraints\HasSameContentAs;

class HasSameContentAsTest extends PHPUnit_Framework_TestCase
{
    protected $hasSameContentAs;
    protected $fileOneHandle = null;
    protected $fileTwoHandle = null;

    protected function setUp()
    {
        // Create the files
        $this->fileOneHandle = fopen(__DIR__.'/../../assets/file_one.txt', 'w') or die('Could not create the first file while setting up tests for HasSameContentTest.');
        $this->fileTwoHandle = fopen(__DIR__.'/../../assets/file_two.txt', 'w') or die('Could not create the second file while setting up tests for HasSameContentTest.');

        $this->hasSameContentAs = new HasSameContentAs(__DIR__.'/../../assets/file_one.txt');
    }

    public function testEvaluateWithCorrectData()
    {
        fwrite($this->fileOneHandle, "a");
        fwrite($this->fileTwoHandle, "a");

        $this->assertTrue($this->hasSameContentAs->evaluate(__DIR__.'/../../assets/file_two.txt'), "Failed to assert that the two file have the same content");
    }

    public function testEvaluateWithIncorrectData()
    {
        fwrite($this->fileOneHandle, "a");
        fwrite($this->fileTwoHandle, "b");

        $this->assertFalse($this->hasSameContentAs->evaluate(__DIR__.'/../../assets/file_two.txt'), "Failed to assert that the two file do not have the same content");
    }

    public function testGetName()
    {
        $this->assertEquals($this->hasSameContentAs->getName(), "HAS_SAME_CONTENT_AS", "Failed to assert COUNT is the constraint name.");
    }

    public function tearDown()
    {
        if ($this->fileOneHandle != null) {
            fclose($this->fileOneHandle);
            unlink(__DIR__.'/../../assets/file_one.txt');
        }

        if ($this->fileTwoHandle != null) {
            fclose($this->fileTwoHandle);
            unlink(__DIR__.'/../../assets/file_two.txt');
        }
    }
}
