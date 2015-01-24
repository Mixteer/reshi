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

class ArrayContainsOnlyInstancesOf implements ReshiConstraint
{
    const NAME = "CONTAINS_ONLY_INSTANCES_OF";

    protected $klass = "";

    public function __construct($klass)
    {
        if (!is_string($klass)) {
            throw new \InvalidArgumentException("The given class must be a string.");
        }

        $this->klass = $klass;
    }

    public function evaluate($haystack)
    {
        // Make sure the haystack is an array
        if (!is_array($haystack)) {
            throw new \InvalidArgumentException("The given haystack must be an array.");            
        }

        // Make sure the array is non-empty
        if (count($haystack) === 0) {
            throw new \InvalidArgumentException("The given haystack must not be empty.");           
        }

        foreach ($haystack as $value) {
            if (!($value instanceof $this->klass)) {
                return false;
            }
        }

        return true;
    }

    public function getName()
    {
        return self::NAME;
    }
}
