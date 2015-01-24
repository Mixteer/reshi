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

class IsGreaterThanOrEqualTo implements ReshiConstraint
{
    const NAME = "IS_GREATER_THAN_OR_EQUAL_TO";

    protected $operandTwo;

    public function __construct($operandTwo)
    {
        $this->operandTwo = $operandTwo;
    }

    public function evaluate($operandOne)
    {
        if ($operandOne >= $this->operandTwo) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
