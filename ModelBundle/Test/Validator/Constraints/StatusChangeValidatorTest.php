<?php

namespace PHPOrchestra\ModelBundle\Test\Validator\Constraints;

use Phake;
use PHPOrchestra\ModelBundle\Validator\Constraints\StatusChange;
use PHPOrchestra\ModelBundle\Validator\Constraints\StatusChangeValidator;

/**
 * Class StatusChangeValidatorTest
 */
class StatusChangeValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var StatusChangeValidator
     */
    protected $validator;

    protected $message = 'message';
    protected $securityContext;
    protected $translator;
    protected $constraint;
    protected $context;
    protected $status;
    protected $role;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->translator = Phake::mock('Symfony\Component\Translation\Translator');
        Phake::when($this->translator)->trans(Phake::anyParameters())->thenReturn($this->message);
        $this->securityContext = Phake::mock('Symfony\Component\Security\Core\SecurityContextInterface');
        $this->constraint = new StatusChange();
        $this->context = Phake::mock('Symfony\Component\Validator\Context\ExecutionContext');
        $this->role = 'ROLE';
        $this->status = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusInterface');
        Phake::when($this->status)->getRole()->thenReturn($this->role);

        $this->validator = new StatusChangeValidator($this->securityContext, $this->translator);
        $this->validator->initialize($this->context);
    }

    /**
     * Test add violation without right
     *
     * @param bool $isGranted
     * @param int  $times
     *
     * @dataProvider provideGrantResponse
     */
    public function testAddViolationOrNot($isGranted, $times)
    {
        Phake::when($this->securityContext)->isGranted(Phake::anyParameters())->thenReturn($isGranted);

        $this->validator->validate($this->status, $this->constraint);

        Phake::verify($this->context, Phake::times($times))->addViolation($this->message);
        Phake::verify($this->translator, Phake::times($times))->trans($this->constraint->message);
        Phake::verify($this->securityContext)->isGranted($this->role);
    }

    /**
     * @return array
     */
    public function provideGrantResponse()
    {
        return array(
            array(true, 0),
            array(false, 1)
        );
    }

    /**
     * Test with no role
     */
    public function testWhenStatusHasNoRole()
    {
        Phake::when($this->status)->getRole()->thenReturn(null);

        $this->validator->validate($this->status, $this->constraint);

        Phake::verify($this->context, Phake::never())->addViolation($this->message);
        Phake::verify($this->translator, Phake::never())->trans($this->constraint->message);
        Phake::verify($this->securityContext, Phake::never())->isGranted($this->role);
    }
}
