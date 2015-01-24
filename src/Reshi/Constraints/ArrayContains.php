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

class ArrayContains implements ReshiConstraint
{
    const NAME = "CONTAINS";

    protected $needle;

    public function __construct($needle)
    {

        $this->needle = $needle;
    }

    public function evaluate($haystack)
    {
        if (!is_array($haystack)) {
            throw new \InvalidArgumentException("The given haystack must be an array.");            
        }

        if (count($haystack) === 0) {
            throw new \InvalidArgumentException("The given haystack must not empty.");          
        }

        foreach ($haystack as $value) {
            if ($this->needle === $value) {
                return true;
            }
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
