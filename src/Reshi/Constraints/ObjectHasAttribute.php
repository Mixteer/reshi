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

class ObjectHasAttribute implements ReshiConstraint
{
    const NAME = "OBJECT_HAS_ATTRIBUTE";

    protected $attribute;

    public function __construct($attribute)
    {
        if (is_string($attribute) === false) {
            throw new \InvalidArgumentException("The attribute to check for on the object must be a string.");
        }

        $this->attribute = $attribute;
    }

    public function evaluate($object)
    {
        if (is_object($object) && property_exists($object, $this->attribute)) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
