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

class ArrayContainsOnly implements ReshiConstraint
{
    const NAME = "CONTAINS_ONLY";

    const BOOL_TYPE = 'bool';
    const INT_TYPE = 'int';
    const FLOAT_TYPE = 'float';
    const STRING_TYPE = 'string';
    const ARRAY_TYPE = 'array';
    const OBJECT_TYPE = 'object';
    const RESOURCE_TYPE = 'resource';
    const NULL_TYPE = 'null';
    const CALLABLE_TYPE = 'callable';

    protected $type = null;

    public function __construct($type)
    {
        if (!is_string($type)) {
            throw new \InvalidArgumentException("The given type must be an array.");            
        }

        if ($this->isValidType($type) === false) {
            throw new \InvalidArgumentException("Invalid type passed to the constraint.");
        }

        $this->type = $type;
    }

    protected function isValidType($type)
    {
        switch ($type) {
            case self::BOOL_TYPE:
            case self::INT_TYPE:
            case self::FLOAT_TYPE:
            case self::STRING_TYPE:
            case self::ARRAY_TYPE:
            case self::OBJECT_TYPE:
            case self::RESOURCE_TYPE:
            case self::NULL_TYPE:
            case self::CALLABLE_TYPE:
                return true;
            default:
                return false;
        }
    }

    protected function getType($element)
    {
        if (is_bool($element)) {
            return self::BOOL_TYPE;
        }

        if (is_int($element)) {
            return self::INT_TYPE;
        }

        if (is_float($element)) {
            return self::FLOAT_TYPE;
        }

        if (is_string($element)) {
            return self::STRING_TYPE;
        }

        if (is_array($element)) {
            return self::ARRAY_TYPE;
        }

        if (is_object($element)) {
            return self::OBJECT_TYPE;
        }

        if (is_null($element)) {
            return self::NULL_TYPE;
        }

        if (is_resource($element)) {
            return self::RESOURCE_TYPE;
        }

        if (is_callable($element)) {
            return self::CALLABLE_TYPE;
        }

        return false;
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

        $previousType = $this->getType($haystack[0]);

        foreach ($haystack as $value) {
            $currentType = $this->getType($value);

            if ($currentType === false) {
                throw new \InvalidArgumentException("The given element is of unknown type. This is a bug, please report.");
            }

            if ($currentType !== $this->type) {
                return false;
            }

            if ($currentType !== $previousType) {
                return false;
            }

            $previousType = $currentType;
        }

        return true;
    }

    public function getName()
    {
        return self::NAME;
    }
}
