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

class IsType implements ReshiConstraint
{
    private static $name = "IS_TYPE";

    const BOOL_TYPE = 'bool';
    const INT_TYPE = 'int';
    const FLOAT_TYPE = 'float';
    const STRING_TYPE = 'string';
    const ARRAY_TYPE = 'array';
    const OBJECT_TYPE = 'object';
    const RESOURCE_TYPE = 'resource';
    const NULL_TYPE = 'null';
    const CALLABLE_TYPE = 'callable';

    protected $type;

    public function __construct($type)
    {
        if (!is_string($type)) {
            throw new \InvalidArgumentException("The type passed to isType must be a string.");
        }

        $this->type = $type;
    }

    public function evaluate($param)
    {
        switch ($this->type) {
            case self::BOOL_TYPE:
                self::$name = "IS_BOOL";
                if (is_bool($param)) {
                    return true;
                }
                break;
            
            case self::INT_TYPE:
                self::$name = "IS_INT";
                if (is_int($param)) {
                    return true;
                }
                break;
            
            case self::FLOAT_TYPE:
                self::$name = "IS_FLOAT";
                if (is_float($param)) {
                    return true;
                }
                break;
            
            case self::STRING_TYPE:
                self::$name = "IS_STRING";
                if (is_string($param)) {
                    return true;
                }
                break;
            
            case self::ARRAY_TYPE:
                self::$name = "IS_ARRAY";
                if (is_array($param)) {
                    return true;
                }
                break;
            
            case self::OBJECT_TYPE:
                self::$name = "IS_OBJECT";
                if (is_object($param)) {
                    return true;
                }
                break;
            
            case self::RESOURCE_TYPE:
                self::$name = "IS_RESOURCE";
                if (is_resource($param)) {
                    return true;
                }
                break;
            
            case self::NULL_TYPE:
                self::$name = "IS_NULL";
                if (is_null($param)) {
                    return true;
                }
                break;
            
            case self::CALLABLE_TYPE:
                self::$name = "IS_CALLABLE";
                if (is_callable($param)) {
                    return true;
                }
                break;

            default:
                self::$name = "IS_TYPE";
                throw new \Exception("Unknown or unsupported type: '". $this->type ."'");
                break;
        }

        return false;
    }

    public function getName()
    {
        return self::$name;
    }
}
