<?php

namespace PHPOrchestra\ModelBundle\Test\Validator\Constraints;

use Phake;
use PHPOrchestra\ModelBundle\Validator\Constraints\PreventProhibitedStatusChange;
use Symfony\Component\Validator\Constraint;

/**
 * Class PreventProhibitedStatusChangeTest
 */
class PreventProhibitedStatusChangeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PreventProhibitedStatusChange
     */
    protected $constraint;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->constraint = new PreventProhibitedStatusChange();
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
        $this->assertSame('prevent_prohibited_status_change', $this->constraint->validatedBy());
    }

    /**
     * test target
     */
    public function testTarget()
    {
        $this->assertSame(Constraint::CLASS_CONSTRAINT, $this->constraint->getTargets());
    }

    /**
     * test message
     */
    public function testMessages()
    {
        $this->assertSame('php_orchestra_model.status.impossible_change', $this->constraint->message);
    }
}
