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

class IsInstanceOf implements ReshiConstraint
{
    const NAME = "IS_INSTANCE_OF";

    protected $klass;

    public function __construct($klass)
    {
        if (!is_string($klass)) {
            throw new \InvalidArgumentException("The class name must be a string, not class literals or other objects.");
        }

        $this->klass = $klass;
    }

    public function evaluate($object)
    {
        if (!is_object($object)) {
            throw new \InvalidArgumentException("Please provide an object for checking against the given class.");
        }

        if ($object instanceof $this->klass) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
