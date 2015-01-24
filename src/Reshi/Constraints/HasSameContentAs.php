<?php
/**
 * Reshi libray - an assertion library.
 *
 * @author      Ntwali Bashige <ntwali.bashige@mixteer.com>
 * @copyright   2015 Mixteer
 * @link        http://os.mixteer.com/baseutils/reshi
 * @license     http://os.mixteer.com/baseutils/reshi/license
 * @version     0.1.0
 *
 * MIT LICENSE
 */

namespace Reshi\Constraints;

use Reshi\ReshiConstraint;

class HasSameContentAs implements ReshiConstraint
{
    const NAME = "HAS_SAME_CONTENT_AS";

    protected $fileTwo;

    public function __construct($fileTwo)
    {
        if (!is_string($fileTwo)) {
            throw new Exception("Given file name is not a string.");
        }

        $this->fileTwo = $fileTwo;
    }

    public function evaluate($fileOne)
    {       
        if (!is_string($fileOne)) {
            throw new Exception("Given file name is not a string.");
        }

        if (!file_exists($fileOne) || !file_exists($this->fileTwo)) {
            throw new \InvalidArgumentException("One of the file to check content for does not exists or is not readable.");
        }

        if (sha1_file($fileOne) !== false && sha1_file($fileOne) === sha1_file($this->fileTwo)) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
