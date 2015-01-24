<?php
/**
 * Reshi libray - an assertion library.
 *
 * @author      Armando Sudi <armando.sudi@mixteer.com>
 * @author      Armando Sudi <ntwali.bashige@mixteer.com>
 * @copyright   2015 Mixteer
 * @link        http://os.mixteer.com/baseutils/reshi
 * @license     http://os.mixteer.com/baseutils/reshi/license
 * @version     0.1.0
 *
 * MIT LICENSE
 */

use Reshi\Assertion;
use Reshi\ReshiConstraint;

class AssertionTest extends PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $assertion = new Assertion;
        $assertionFromInvoke = $assertion(TRUE);

        $this->assertSame($assertion, $assertionFromInvoke, "Failed to assert that the object returned by invoke is not the same as the one returned by the constructor.");
    }

    public function testAssertThat()
    {
        $this->assertTrue(Assertion::assertThat(true, new ConstraintTest, true), "Failed to assert that the constraint returned true when given a boolean.");
        $this->assertTrue(Assertion::assertThat("true", new ConstraintTest, false), "Failed to assert that the assertThat method will not trigger an error when it's last parameter is 'false'.");
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testAssertThatWithErrorTriggered()
    {
        $this->assertFalse(Assertion::assertThat("null", new ConstraintTest, true), "Failed to assert that the constraint returned false when not given a boolean.");
        $this->assertTrue(Assertion::assertThat(true, new ConstraintTest, false), "Failed to assert that the assertThat method will not trigger an error when it's last parameter is 'false'.");
    }
}

class ConstraintTest implements ReshiConstraint
{
    const NAME = "CONSTRAINT_TEST";

    public function evaluate($param)
    {
        if (is_bool($param)) {
            return true;
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
