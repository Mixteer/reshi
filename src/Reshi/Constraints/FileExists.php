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

class FileExists implements ReshiConstraint
{
    const NAME = "FILE_EXISTS";

    protected $file;

    public function __construct($file)
    {
        if (!is_string($file)) {
            throw new Exception("Given file name is not a string.");
        }

        $this->file = $file;
    }

    public function evaluate($filler = null)
    {
        if (file_exists($this->file)) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
