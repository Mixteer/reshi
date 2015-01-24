# Reshi - facilitating assertive programming

> "If It Can't Happen, Use Assertions to Ensure That It Won't" -- A. Hunt and D. Thomas in The Pragmatic Programmer.

Reshi is an assertion library that it meant to check constraints you impose on say function input parameters. The idea behind it is that of assertive programming as found in **Section 23, Chapter 4 of the book The Pragmatic Programmer.**

You use Reshi to make sure that event that you think will never occur doesn't cause damage in case it does occur. See Section 22 Dead programs tell no lies of the same chapter.

## Install

The library is available on [packagist](https://packagist.org/) and installable via [composer](http://getcomposer.org).

```JSON
{
    "require": {
        "mixteer/reshi": :"0.1.*"
    }
}
```

## Concepts

The 3 main concepts about the why and how of this library are derived from **The Pragmatic Programmer** in Chapter 4:

1. *Assertive programming* - you use assertions to make sure things that shouldn't normally happen are guarded against just in case they do happen.

2. *Dead programs tell no lies* - if an assertion fails, the library triggers a `E_USER_ERROR` error which ends the program immediately. You'll have an error handler which should log this error as it will contain the details of which assertion failed and details like file name and line number.

3. *Use exceptions for exceptional cases* - the library doesn't throw an exception when the assertion fails simply to help avoid someone catching the exception, doing nothing with it and hence the program might continue. Yes, errors can be converted into exceptions but going to all that trouble assumes you have a good idea and fair reason for doing so. Note that while assertions help guard against rare bad events, those are not part of your business logic so use of exceptions here is not a good idea. But when the library methods are given wrong  parameters, the will emit exceptions because that's part of their business logic.

## Usage

Using the library is fairly simple:

```php
<?php
$assertThat = new Assertion;

$title = "The Pragmatic Programmer";

# Fails if the title is not a string
# Using an instance of Assertion
$assertThat($title)->isString();

# Using a static method
Assertion::assertIsString($title);

# Fails if the title is null
# Using an instance of Assertion
$assertThat($title)->isNotNull();

# Using a static method
Assertion::assertIsNotNull($title);
```

It is very likely that you'll use this method in a class and `$this->assertThat` will pause a problem since PHP will look for the method `assertThat` in the current class.  
There are a number of ways to go around this problem:

+ **Helper method:**  
Create a helper method that is returns an instance of the `Assertion` and use it. The problem with this approach is that it creates many `Assertion` objects. So this is solution is generally not recommended.

```php
<?php
function assertThat($param)
{
    $assertThat = new Assertion;
    return $assertThat($param);
}

class User
{
    protected $name;
    
    public function changeName($name)
    {
        // Make sure the name is a string and is not empty
        assertThat($name)->isString();
        $assertThat($name)->isNotEmpty(); // !Don't this to check if a string is empty in production code
    }
}
```
  
+ **Helper method with caching:**  
We can also cache the result of the previous function call and reuse the object that was previously constructed. This is much better since we'll reuse the same assertion object between multiple calls. Notice that we take care to change the parameter the assertion is working with else it will reuse the old one.

```php
<?php
function assertThat($param)
{
    static $assertion = [];
    
    if (count($assertion) > 0) {
        $assertThat = $assertion[0];
        $assertThat->changeParameter($param);
    } else {
        $assertThat = new Assertion;
        $assertion[] = $assertThat($param);
    }    

    return $assertThat;
}

class User
{
    protected $name;
    
    public function changeName($name)
    {
        // Make sure the name is a string and is not empty
        assertThat($name)->isString();
        $assertThat($name)->isNotEmpty(); // !Don't this to check if a string is empty in production code
    }
}
```

+ **Implement *__call*: **  
In this approach, you implement the magic method *__call* to intercept "the missing method", execute it which then returns the result we want.

```php
<?php
class User
{
    protected $name = "";
    protected $assertThat = null;
    
    public function __construct()
    {
        $this->assertThat = new Assertion;
    }
    
    public function changeName($name)
    {
        $this->assertThat($name)->isString();
        
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    // Without this method, the code would fail with a message such as the method User::assertThat() could not be found.
    public function __call($method, $args)
    {
        if (is_callable(array($this, $method))) {
            return call_user_func_array($this->{$method}, $args);
        }
    }       
}
```

For developers heavily using domain models, the *__call* method would ideally go on a [Layer supertype](http://martinfowler.com/eaaCatalog/layerSupertype.html) so as to avoid duplication.

+ **Create a namespaced function:**  
Let's assume again you're using a Layer Supertype. Instead of implementing the *__call* method, you'd create a function in the same class as the Layer Supertype class and import it (as of PHP 5.6+).

```php
<?php
namespace Domain\Model;

use Reshi\Assertion;

function assertThat($param)
{
    static $assertion = [];
    
    if (count($assertion) > 0) {
        $assertThat = $assertion[0];
        $assertThat->changeParameter($param);
    } else {
        $assertThat = new Assertion;
        $assertion[] = $assertThat($param);
    }    

    return $assertThat;
}

class LayerSupertype
{
    protected $id;
    
    // Method common to all domain models go here
}
```

**Usage go as this:**  
```php
<?php
namespace Domain\Model\Users;

use function Domain\Model\assertThat;

class User
{
    protected $name = "";
    
    public function changeName($name)
    {
        assertThat($name)->isString();
        
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }  
}
```


## Assertions

This is not an exhaustive list of assertions yet but we
re adding more in this documentation and in the code as fast as we can.

- _assertIsTrue($param)_: Stops the execution of the program if `$param` is false.  
Method: _isTrue()_.  
Static example: Assertion::assertIsTrue(true);
Instance example: $assertThat(true)->isTrue();

- _assertIsFalse($param)_: Stops the execution of the program if `$param` is true.   
Method: _isFalse()_.  
Static example: Assertion::assertIsFalse(false);
Instance example: $assertThat(true)->isFalse();

- _assertIsInstanceOf($object, string $klass)_: Stops the execution of the program if `$object` is not an instance of `$klass`.  
Method: _isInstanceOf(string $klass)_.  
Static example: Assertion::assertIsInstanceOf($user, 'User');
Instance example: $assertThat($user)->isInstanceOf('User');

- _assertIsNotInstanceOf($object, string $klass)_: Stops the execution of the program if `$object` is an instance of `$klass`.  
Method: _isNotInstanceOf(string $klass)_.  
Static example: Assertion::assertIsNotInstanceOf($user, 'User');
Instance example: $assertThat($user)->isNotInstanceOf('User');

> For now, looking into the `Assertion.php` file will show all the assertions. Bellow is an undocumented list of the assertions but we'll documenting them slowly.

- _assertIsType($param, string $type)_  
- _assertIsBool($param)_  
- _assertIsInt($param)_  
- _assertIsFloat($param)_  
- _assertIsString($param)_  
- _assertIsArray($param)_  
- _assertIsObject($param)_  
- _assertIsResource($param)_  
- _assertIsCallable($param)_  
- _assertIsNull($param)_  
- _assertIsEmpty($param)_
- _assertHasCount($array)_  
- _assertEquals($operandOne, $operandTwo)_  
- _assertIsGreaterThan($operandOne, $operandTwo)_  
- _assertIsGreaterThanOrEqualTo($operandOne, $operandTwo)_  
- _assertIsLessThan($operandOne, $operandTwo)_  
- _assertIsLessThanOrEqualTo($operandOne, $operandTwo)_  
- _assertSame($operandOne, $operandTwo)_  
- _assertFileExists(string $file)_  
- _assertHasSameContent(string $fileOne, string $fileTwo)_  
- _assertEqualsFile(string $string, string $file)_  
- _assertStartsWith(string $needle, string $string)_  
- _assertEndsWith(string $needle, string $string)_  
- _assertArrayContains($needle, array $haystack)_  
- _assertArrayContainsOnly(string $type, array $haystack)_ 
- _assertArrayContainsOnlyInstancesOf(string $klass, array $haystack)_  
- _assertArrayHasKey($key, array $haystack)_  
- _assertObjectHasAttribute(string $attribute, object $object)_  

Each of those static methods has an instance counterpart (which might not have the same "signature" and a negation counterpart as well.


## Adding new assertions

Reshi allows you to create new assertions of your own.  
To add a new assertion, you just implement the interface `ReshiConstraint`. Follow the example bellow to see how this is done.

+ **Implement the `ReshiConstraint` interface:**  
This interface requires two method: `evaluate()` which will be called by the static method `assertThat` and `getName()` which must return a string whose content is the name of the constraint. This name is included in the failure message to allow the developer to identify which assertion failed.

```php
<?php
namespace MyConstraints;

use Reshi\ReshiConstraint;

class HasBeenSet implements ReshiConstraint
{
    const NAME = "HAS_BEEN_SET";

    public function __construct()
    {
    }

    public function evaluate($param)
    {
        if (isset($param)) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
```

+ ** Extend the `Assertion` class:**  
You might want to extend the `Assertion` class so that you can have a unified assertion class with all th existing methods from the library accessible.

```php
<?php
namespace MyAssertions;

use Reshi\Assertion;
use MyConstraints\HasBeenSet;

class MyAssertion extends Assertion
{
    public static function assertHasBeenSert($param)
    {
        self::$callFromInside += 1; // This is used for backstracing - must always be there
        return self::assertThat($param, new HasBeenSet);
    }

    public function hasBeenSet()
    {
        self::$callFromInside += 1;
        return self::assertHasBeen($this->param);
    }
    
    public static function assertHasNotBeenSert($param)
    {
        self::$callFromInside += 1; // This is used for backstracing - must always be there
        return self::assertThat($param, new HasBeenSet, false); // Pass false to get the constraint to fial if its evaluation returns true
    }

    public function hasNotBeenSet()
    {
        self::$callFromInside += 1;
        return self::assertHasNotBeen($this->param);
    }
}
```

Now you can use `MyAssertion` instead of `Assertion` and have access to both your assertions and the existing assertions.

## About
### Requirements
Reshi has been test on PHP 5.5 but all the features should work from PHP 5.3 - see `composer.json`. Testing on other platforms is welcome. Email one the authors bellow.

### Bugs and feature requests
All bugs and feature requests are tracked on [GitHub](https://github.com/Mixteer/reshi/issues).

### Contributing
Please send us a pull request.

### Tests
To run tests:  

```cli
$ phpunit
```

### Authors
Ntwali Bashige - ntwali.bashige@gmail.com - [http://twitter.com/nbashige  ](http://twitter.com/nbashige)  
Armando Sudi - [https://github.com/ArmandoSudi](https://github.com/ArmandoSudi)

### License
Reshi is licensed under `MIT`, see LICENSE file.

### Acknowledgment
The assertions are inspired from [PHPUnit](https://phpunit.de).
