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

class StartsWith implements ReshiConstraint
{
    const NAME = "STARTS_WITH";

    protected $needle;

    public function __construct($needle)
    {
        $this->needle = $needle;
    }

    public function evaluate($string)
    {
        $needleLength = strlen($this->needle);

        if (substr($string, 0, $needleLength) === $this->needle) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
