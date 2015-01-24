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

class HasCount implements ReshiConstraint
{
    const NAME = "HAS_COUNT";

    protected $count;

    public function __construct($count)
    {
        if (!is_int($count)) {
            throw new \IllegalArgumentException("The count for the number of elements in an array must be an iinteger.");
        }
        $this->count = $count;
    }

    public function evaluate($array)
    {
        if (count($array) === $this->count) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
