<?php

namespace PHPOrchestra\ModelBundle\Test\Validator\Constraints;

use PHPOrchestra\ModelBundle\Validator\Constraints\CheckAreaPresence;
use Symfony\Component\Validator\Constraint;

/**
 * Class CheckAreaPresenceTest
 */
class CheckAreaPresenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CheckAreaPresence
     */
    protected $constraint;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->constraint = new CheckAreaPresence();
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
        $this->assertSame('check_area_presence', $this->constraint->validatedBy());
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
        $this->assertSame('php_orchestra_model.area.presence_required', $this->constraint->message);
    }
}
