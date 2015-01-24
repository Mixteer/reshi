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

namespace Reshi;

// Booleans
use Reshi\Constraints\IsTrue;
use Reshi\Constraints\IsFalse;

// Types
use Reshi\Constraints\IsType;

// Arrays
use Reshi\Constraints\IsEmpty;
use Reshi\Constraints\HasCount;
use Reshi\Constraints\ArrayHasKey;
use Reshi\Constraints\ArrayContains;
use Reshi\Constraints\ArrayContainsOnly;
use Reshi\Constraints\ArrayContainsOnlyInstancesOf;

// Objects
use Reshi\Constraints\IsInstanceOf;
use Reshi\Constraints\ObjectHasAttribute;

// Comparison operators
use Reshi\Constraints\Equals;
use Reshi\Constraints\IsGreaterThan;
use Reshi\Constraints\IsGreaterThanOrEqualTo;
use Reshi\Constraints\IsLessThan;
use Reshi\Constraints\IsLessThanOrEqualTo;
use Reshi\Constraints\Same;

// Files
use Reshi\Constraints\FileExists;
use Reshi\Constraints\HasSameContentAs;

// Strings
use Reshi\Constraints\StartsWith;
use Reshi\Constraints\EndsWith;
use Reshi\Constraints\EqualsFile;


class Assertion
{
    protected $param;

    protected static $callFromInside = 0;

    public function __construct()
    {
    }

    public function __invoke($param)
    {
        $this->param = $param;
        return $this;
    }

    public function changeParameter($param)
    {
        $this->param = $param;
    }

    /**
     * Check if the constraint evaluates to true else trigger an error
     *
     * @param   $constraint     the constraint to evaluate
     */
    public static function assertThat($param, ReshiConstraint $constraint, $expected = true)
    {
        if (!is_bool($expected)) {
            throw new \InvalidArgumentException("The expected result after the constraint evaluation must be a boolean, true or false.");
        }

        if ($constraint->evaluate($param) === $expected) {
            return true;
        }

        $debugTrace = debug_backtrace();

        // Get the calling function details by shifting values from the call stack
        while (self::$callFromInside != 0) {
            array_shift($debugTrace);
            self::$callFromInside--;
        }       
        $caller = array_shift($debugTrace);

        if (is_object($param)) {
            trigger_error("The object failed the constraint imposed on it. The constraint is ". $constraint->getName() .". This happened in file '". $caller['file'] ."' on line '". $caller['line'] ."'.", E_USER_ERROR);
        }

        if (is_array($param)) {
            trigger_error("The array failed the constraint imposed on it. The constraint is ". $constraint->getName() .". This happened in file '". $caller['file'] ."' on line '". $caller['line'] ."'.", E_USER_ERROR);
        }

        if (is_callable($param)) {
            trigger_error("The function failed the constraint imposed on it. The constraint is ". $constraint->getName() .". This happened in file '". $caller['file'] ."' on line '". $caller['line'] ."'.", E_USER_ERROR);
        }

        if (is_resource($param)) {
            trigger_error("The resource failed the constraint imposed on it. The constraint is ". $constraint->getName() .". This happened in file '". $caller['file'] ."' on line '". $caller['line'] ."'.", E_USER_ERROR);
        }

        if (is_null($param)) {
            trigger_error("The parameter with value 'null' failed the constraint imposed on it. The constraint is ". $constraint->getName() .". This happened in file '". $caller['file'] ."' on line '". $caller['line'] ."'.", E_USER_ERROR);
        }

        trigger_error("The parameter with value '". $param ."' failed the constraint imposed on it. The constraint is ". $constraint->getName() .". This happened in file '". $caller['file'] ."' on line '". $caller['line'] ."'.", E_USER_ERROR);     
    }

    /**
     * Stop the script execution if the passed in argument is not true
     */
    public static function assertIsTrue($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsTrue);
    }

    public function isTrue()
    {
        self::$callFromInside += 1;
        return self::assertIsTrue($this->param);
    }

    public function assertIsFalse($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsFalse);
    }

    public function isFalse()
    {
        self::$callFromInside += 1;
        return self::assertIsFalse($this->param);
    }

    /**
     * Stop the script execution if the passed in $object is not an instance of $klass
     */
    public static function assertIsInstanceOf($object, $klass)
    {
        self::$callFromInside += 1;
        return self::assertThat($object, new IsInstanceOf($klass));
    }

    public function isInstanceOf($klass)
    {
        self::$callFromInside += 1;
        return self::assertIsInstanceOf($this->param, $klass);
    }

    /**
     * Stop the script execution if the passed in $object is an instance of $klass
     */
    public static function assertIsNotInstanceOf($object, $klass)
    {
        self::$callFromInside += 1;
        return self::assertThat($object, new IsInstanceOf($klass), false);
    }

    public function isNotInstanceOf($klass)
    {
        self::$callFromInside += 1;
        return self::assertIsNotInstanceOf($this->param, $klass);
    }

    /**
     * Stop the script execution if the passed in $param is not of the passed in $type
     */
    public static function assertIsType($param, $type)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType($type));
    }

    public function isType($type)
    {
        self::$callFromInside += 1;
        return self::assertIsType($this->param, $type);
    }

    /**
     * Stop the script execution if the passed in $param is of type $type
     */
    public static function assertIsNotType($param, $type)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType($type), false);
    }

    public function isNotType($type)
    {
        self::$callFromInside += 1;
        return self::assertIsNotType($this->param, $type);
    }

    /**
     * Stop the script execution if the passed in $param is not of type BOOL
     */
    public static function assertIsBool($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('bool'));
    }

    public function isBool()
    {
        self::$callFromInside += 1;
        return self::assertIsBool($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is of type BOOL
     */
    public static function assertIsNotBool($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('bool'), false);
    }

    public function isNotBool()
    {
        self::$callFromInside += 1;
        return self::assertIsNotBool($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is not of type INT
     */
    public static function assertIsInt($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('int'));
    }

    public function isInt()
    {
        self::$callFromInside += 1;
        return self::assertIsInt($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is of type INT
     */
    public static function assertIsNotInt($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('int'), false);
    }

    public function isNotInt()
    {
        self::$callFromInside += 1;
        return self::assertIsNotInt($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is not of type FLOAT
     */
    public static function assertIsFloat($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('float'));
    }

    public function isFloat()
    {
        self::$callFromInside += 1;
        return self::assertIsFloat($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is of type FLOAT
     */
    public static function assertIsNotFloat($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('float'), false);
    }

    public function isNotFloat()
    {
        self::$callFromInside += 1;
        return self::assertIsNotFloat($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is not of type STRING
     */
    public static function assertIsString($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('string'));
    }

    public function isString()
    {
        self::$callFromInside += 1;
        return self::assertIsString($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is of type STRING
     */
    public static function assertIsNotString($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('string'), false);
    }

    public function isNotString()
    {
        self::$callFromInside += 1;
        return self::assertIsNotString($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is not of type ARRAY
     */
    public static function assertIsArray($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('array'));
    }

    public function isArray()
    {
        self::$callFromInside += 1;
        return self::assertIsArray($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is of type ARRAY
     */
    public static function assertIsNotArray($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('array'), false);
    }

    public function isNotArray()
    {
        self::$callFromInside += 1;
        return self::assertIsNotArray($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is not of type OBJECT
     */
    public static function assertIsObject($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('object'));
    }

    public function isObject()
    {
        self::$callFromInside += 1;
        return self::assertIsObject($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is of type OBJECT
     */
    public static function assertIsNotObject($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('object'), false);
    }

    public function isNotObject()
    {
        self::$callFromInside += 1;
        return self::assertIsNotObject($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is not of type OBJECT
     */
    public static function assertIsResource($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('resource'));
    }

    public function isResource()
    {
        self::$callFromInside += 1;
        return self::assertIsResource($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is of type OBJECT
     */
    public static function assertIsNotResource($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('resource'), false);
    }

    public function isNotResource()
    {
        self::$callFromInside += 1;
        return self::assertIsNotResource($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is not of type NULL
     */
    public static function assertIsNull($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('null'));
    }

    public function isNull()
    {
        self::$callFromInside += 1;
        return self::assertIsNull($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is of type NULL
     */
    public static function assertIsNotNull($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('null'), false);
    }

    public function isNotNull()
    {
        self::$callFromInside += 1;
        return self::assertIsNotNull($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is not of type CALLABLE
     */
    public static function assertIsCallable($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('callable'));
    }

    public function isCallable()
    {
        self::$callFromInside += 1;
        return self::assertIsCallable($this->param);
    }

    /**
     * Stop the script execution if the passed in $param is of type CALLABLE
     */
    public static function assertIsNotCallable($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsType('callable'), false);
    }

    public function isNotCallable()
    {
        self::$callFromInside += 1;
        return self::assertIsNotCallable($this->param);
    }

    /**
     * Stop the script execution if the passed in argument is not empty
     */
    public static function assertIsEmpty($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsEmpty);
    }

    public function isEmpty()
    {
        self::$callFromInside += 1;
        return self::assertIsEmpty($this->param);
    }

    /**
     * Stop the script execution if the passed in argument is empty
     */
    public static function assertIsNotEmpty($param)
    {
        self::$callFromInside += 1;
        return self::assertThat($param, new IsEmpty, false);
    }

    public function isNotEmpty()
    {
        self::$callFromInside += 1;
        return self::assertIsNotEmpty($this->param);
    }

    /**
     * Stop the script execution if $count is not the number of elements in $array
     */
    public static function assertHasCount($count, $array)
    {
        self::$callFromInside += 1;
        return self::assertThat($array, new HasCount($count));
    }

    public function hasCount($count)
    {
        self::$callFromInside += 1;
        return self::assertHasCount($count, $this->param);
    }

    /**
     * Stop the script execution if $operandOne does not equals $operandTwo
     */
    public static function assertEquals($operandOne, $operandTwo)
    {
        self::$callFromInside += 1;
        return self::assertThat($operandOne, new Equals($operandTwo));
    }

    public function equals($operand)
    {
        self::$callFromInside += 1;
        return self::assertEquals($this->param, $operand);
    }

    /**
     * Stop the script execution if $operandOne does equals $operandTwo
     */
    public static function assertEqualsNot($operandOne, $operandTwo)
    {
        self::$callFromInside += 1;
        return self::assertThat($operandOne, new Equals($operandTwo), false);
    }

    public function equalsNot($operand)
    {
        self::$callFromInside += 1;
        return self::assertEqualsNot($this->param, $operand);
    }

    /**
     * Stop the script execution if $operandOne is not greater than $operandTwo
     */
    public static function assertIsGreaterThan($operandOne, $operandTwo)
    {
        self::$callFromInside += 1;
        return self::assertThat($operandOne, new IsGreaterThan($operandTwo));
    }

    public function isGreaterThan($operand)
    {
        self::$callFromInside += 1;
        return self::assertIsGreaterThan($this->param, $operand);
    }

    /**
     * Stop the script execution if $operandOne is not greater than or equal to $operandTwo
     */
    public static function assertIsGreaterThanOrEqualTo($operandOne, $operandTwo)
    {
        self::$callFromInside += 1;
        return self::assertThat($operandOne, new IsGreaterThanOrEqualTo($operandTwo));
    }

    public function isGreaterThanOrEqualTo($operand)
    {
        self::$callFromInside += 1;
        return self::assertIsGreaterThanOrEqualTo($this->param, $operand);
    }

    /**
     * Stop the script execution if $operandOne is not less than $operandTwo
     */
    public static function assertIsLessThan($operandOne, $operandTwo)
    {
        self::$callFromInside += 1;
        return self::assertThat($operandOne, new IsLessThan($operandTwo));
    }

    public function isLessThan($operand)
    {
        self::$callFromInside += 1;
        return self::assertIsLessThan($this->param, $operand);
    }

    /**
     * Stop the script execution if $operandOne is not lesser than or equal to $operandTwo
     */
    public static function assertIsLessThanOrEqualTo($operandOne, $operandTwo)
    {
        self::$callFromInside += 1;
        return self::assertThat($operandOne, new IsLessThanOrEqualTo($operandTwo));
    }

    public function isLessThanOrEqualTo($operand)
    {
        self::$callFromInside += 1;
        return self::assertIsLessThanOrEqualTo($this->param, $operand);
    }

    /**
     * Stop the script execution if $operandOne is not the same as $operandTwo
     */
    public static function assertSame($operandOne, $operandTwo)
    {
        self::$callFromInside += 1;
        return self::assertThat($operandOne, new Same($operandTwo));
    }

    public function isSameAs($operand)
    {
        self::$callFromInside += 1;
        return self::assertSame($this->param, $operand);
    }

    /**
     * Stop the script execution if $operandOne is the same as $operandTwo
     */
    public static function assertNotSame($operandOne, $operandTwo)
    {
        self::$callFromInside += 1;
        return self::assertThat($operandOne, new Same($operandTwo), false);
    }

    public function isNotSameAs($operand)
    {
        self::$callFromInside += 1;
        return self::assertNotSame($this->param, $operand);
    }

    /**
     * Stop the script execution if $file does not exists
     */
    public static function assertFileExists($file)
    {
        self::$callFromInside += 1;
        return self::assertThat(null, new FileExists($file));
    }

    public function fileExists($file)
    {
        self::$callFromInside += 1;
        return self::assertFileExists($file);
    }

    /**
     * Stop the script execution if $file does exists
     */
    public static function assertFileExistsNot($file)
    {
        self::$callFromInside += 1;
        return self::assertThat(null, new FileExists($file), false);
    }

    public function fileExistsNot($file)
    {
        self::$callFromInside += 1;
        return self::assertFileExistsNot($file);
    }

    /**
     * Stop the script execution if $fileOne does have the same content as $fileTwo
     */
    public static function assertHasNotSameContent($fileOne, $fileTwo)
    {
        self::$callFromInside += 1;
        return self::assertThat($fileOne, new HasSameContentAs($fileTwo), false);
    }

    public function hasNotSameContentAs($file)
    {
        self::$callFromInside += 1;
        return self::assertHasNotSameContent($this->param, $file);
    }

    /**
     * Stop the script execution if $string does not start with $needle
     */
    public static function assertStartsWith($needle, $string)
    {
        self::$callFromInside += 1;
        return self::assertThat($string, new StartsWith($needle));
    }

    public function startsWith($needle)
    {
        self::$callFromInside += 1;
        return self::assertStartsWith($needle, $this->param);
    }

    /**
     * Stop the script execution if $string does start with $needle
     */
    public static function assertStartsNotWith($needle, $string)
    {
        self::$callFromInside += 1;
        return self::assertThat($string, new StartsWith($needle), false);
    }

    public function startsNotWith($needle)
    {
        self::$callFromInside += 1;
        return self::assertStartsNotWith($needle, $this->param);
    }

    /**
     * Stop the script execution if $string does not end with $needle
     */
    public static function assertEndsWith($needle, $string)
    {
        self::$callFromInside += 1;
        return self::assertThat($string, new EndsWith($needle));
    }

    public function endsWith($needle)
    {
        self::$callFromInside += 1;
        return self::assertEndsWith($needle, $this->param);
    }

    /**
     * Stop the script execution if $string does end with $needle
     */
    public static function assertEndsNotWith($needle, $string)
    {
        self::$callFromInside += 1;
        return self::assertThat($string, new EndsWith($needle), false);
    }

    public function endsNotWith($needle)
    {
        self::$callFromInside += 1;
        return self::assertEndsNotWith($needle, $this->param);
    }

    /**
     * Stop the script execution if $string does not have the same content as $file
     */
    public static function assertEqualsFile($string, $file)
    {
        self::$callFromInside += 1;
        return self::assertThat($string, new EqualsFile($file));
    }

    public function equalsFile($file)
    {
        self::$callFromInside += 1;
        return self::assertEqualsFile($this->param, $file);
    }

    /**
     * Stop the script execution if $string does have the same content as $file
     */
    public static function assertEqualsNotFile($string, $file)
    {
        self::$callFromInside += 1;
        return self::assertThat($string, new EqualsFile($file), false);
    }

    public function equalsNotFile($file)
    {
        self::$callFromInside += 1;
        return self::assertEqualsNotFile($this->param, $file);
    }

    /**
     * Stop the script execution if $haystack doesn't contain $needle
     */
    public static function assertArrayContains($needle, $haystack)
    {
        self::$callFromInside += 1;
        return self::assertThat($haystack, new ArrayContains($needle));
    }

    public function contains($needle)
    {
        self::$callFromInside += 1;
        return self::assertArrayContains($needle, $this->param);
    }

    /**
     * Stop the script execution if $haystack contains $needle
     */
    public static function assertArrayContainsNot($needle, $haystack)
    {
        self::$callFromInside += 1;
        return self::assertThat($haystack, new ArrayContains($needle), false);
    }

    public function containsNot($needle)
    {
        self::$callFromInside += 1;
        return self::assertArrayContainsNot($needle, $this->param);
    }

    /**
     * Stop the script execution if $haystack doesn't contain only element of type $type
     */
    public static function assertArrayContainsOnly($type, $haystack)
    {
        self::$callFromInside += 1;
        return self::assertThat($haystack, new ArrayContainsOnly($type));
    }

    public function containsOnly($type)
    {
        self::$callFromInside += 1;
        return self::assertArrayContainsOnly($type, $this->param);
    }

    /**
     * Stop the script execution if $haystack contains only element of type $type
     */
    public static function assertArrayContainsNotOnly($type, $haystack)
    {
        self::$callFromInside += 1;
        return self::assertThat($haystack, new ArrayContainsOnly($type), false);
    }

    public function containsNotOnly($type)
    {
        self::$callFromInside += 1;
        return self::assertArrayContainsNotOnly($type, $this->param);
    }

    /**
     * Stop the script execution if $haystack doesn't contain only instances of $klass
     */
    public static function assertArrayContainsOnlyInstancesOf($klass, $haystack)
    {
        self::$callFromInside += 1;
        return self::assertThat($haystack, new ArrayContainsOnlyInstancesOf($klass));
    }

    public function containsOnlyInstancesOf($klass)
    {
        self::$callFromInside += 1;
        return self::assertArrayContainsOnlyInstancesOf($klass, $this->param);
    }

    /**
     * Stop the script execution if $haystack contains only instances of $klass
     */
    public static function assertArrayContainsNotOnlyInstancesOf($klass, $haystack)
    {
        self::$callFromInside += 1;
        return self::assertThat($haystack, new ArrayContainsOnlyInstancesOf($klass), false);
    }

    public function containsNotOnlyInstancesOf($klass)
    {
        self::$callFromInside += 1;
        return self::assertArrayContainsNotOnlyInstancesOf($klass, $this->param);
    }

    /**
     * Stop the script execution if the passed in key doesn't exist in the existing array in $this->param
     */
    public static function assertArrayHasKey($key, $array)
    {
        self::$callFromInside += 1;
        return self::assertThat($array, new ArrayHasKey($key));
    }

    public function hasKey($key)
    {
        self::$callFromInside += 1;
        return self::assertArrayHasKey($this->param, $key);
    }

    /**
     * Stop the script execution if the passed in key exists in the existing array in $this->param
     */
    public static function assertArrayHasNotKey($key, $array)
    {
        self::$callFromInside += 1;
        return self::assertThat($array, new ArrayHasKey($key), false);
    }

    public function hasNotKey($key)
    {
        self::$callFromInside += 1;
        return self::assertArrayHasNotKey($this->param, $key);
    }

    /**
     * Stop the script execution if the passed in attribute is not a property of the pbject in $this->param
     */
    public static function assertObjectHasAttribute($attribute, $object)
    {
        self::$callFromInside += 1;
        return self::assertThat($object, new ObjectHasAttribute($attribute));
    }

    public function hasAttribute($attribute)
    {
        return self::assertObjectHasAttribute($this->param, $attribute);
    }

    /**
     * Stop the script execution if the passed in attribute is a property of the pbject in $this->param
     */
    public static function assertObjectHasNotAttribute( $attribute, $object)
    {
        self::$callFromInside += 1;
        return self::assertThat($object, new ObjectHasAttribute($attribute), false);
    }

    public function hasNotAttribute($attribute)
    {
        return self::assertObjectHasNotAttribute($this->param, $attribute);
    }   
}
