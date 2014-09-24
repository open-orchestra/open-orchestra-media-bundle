<?php

namespace PHPOrchestra\ModelBundle\Test\Validator\Constraints;

use Phake;
use PHPOrchestra\ModelBundle\Validator\Constraints\StatusChange;
use Symfony\Component\Validator\Constraint;

/**
 * Class StatusChangeTest
 */
class StatusChangeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StatusChange
     */
    protected $constraint;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->constraint = new StatusChange();
    }

    /**
     * Test instance
     */
    public function testInstance()
    {
        $this->assertInstanceOf('Symfony\Component\Validator\Constraint', $this->constraint);
    }

    /**
     * Test validateBy
     */
    public function testValidateBy()
    {
        $this->assertSame('status_change', $this->constraint->validatedBy());
    }

    /**
     * test target
     */
    public function testTarget()
    {
        $this->assertSame(Constraint::PROPERTY_CONSTRAINT, $this->constraint->getTargets());
    }
}
