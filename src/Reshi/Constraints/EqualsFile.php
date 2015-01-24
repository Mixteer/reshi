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

class EqualsFile implements ReshiConstraint
{
    const NAME = "EQUALS_FILE";

    protected $file;

    public function __construct($file)
    {
        if (!is_string($file)) {
            throw new Exception("Given file name is not a string.");
        }

        if (!file_exists($file)) {
            throw new \InvalidArgumentException("The file whose content to use for comparison with the string does not exists.");
        }

        $this->file = $file;
    }

    public function evaluate($string)
    {
        $fileContent = file_get_contents($this->file);
        $fileContent = rtrim($fileContent);

        if ($string === $fileContent) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
