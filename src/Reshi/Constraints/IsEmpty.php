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

class IsEmpty implements ReshiConstraint
{
    const NAME = "IS_EMPTY";

    public function __construct()
    {
    }

    public function evaluate($param)
    {
        if (empty($param)) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
