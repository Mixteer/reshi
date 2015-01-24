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

class ArrayHasKey implements ReshiConstraint
{
    const NAME = "ARRAY_HAS_KEY";

    protected $key;

    public function __construct($key)
    {
        if (is_string($key) === false) {
            throw new \InvalidArgumentException("The key to check in the array must be a string.");
        }

        $this->key = $key;
    }

    public function evaluate($array)
    {
        if (is_array($array) && array_key_exists($this->key, $array)) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
