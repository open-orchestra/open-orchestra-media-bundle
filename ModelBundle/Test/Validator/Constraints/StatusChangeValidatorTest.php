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
    protected $statusRepository;
    protected $securityContext;
    protected $nodeRepository;
    protected $translator;
    protected $constraint;
    protected $oldStatus;
    protected $oldRole;
    protected $oldNode;
    protected $context;
    protected $status;
    protected $role;
    protected $node;

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
        Phake::when($this->status)->getToRole()->thenReturn($this->role);

        $this->node = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        Phake::when($this->node)->getStatus()->thenReturn($this->status);

        $this->oldRole = 'OLD_ROLE';
        $this->oldStatus = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusInterface');
        Phake::when($this->oldStatus)->getFromRole()->thenReturn($this->oldRole);

        $this->oldNode = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        Phake::when($this->oldNode)->getStatus()->thenReturn($this->oldStatus);

        $this->nodeRepository = Phake::mock('PHPOrchestra\ModelBundle\Repository\NodeRepository');
        Phake::when($this->nodeRepository)->find(Phake::anyParameters())->thenReturn($this->oldNode);

        $this->validator = new StatusChangeValidator($this->securityContext, $this->translator, $this->nodeRepository);
        $this->validator->initialize($this->context);
    }

    /**
     * Test add violation without right
     *
     * @param bool $isGrantedNew
     * @param bool $isGrantedOld
     * @param int  $numberOfViolation
     *
     * @dataProvider provideGrantResponse
     */
    public function testAddViolationOrNot($isGrantedNew, $isGrantedOld, $numberOfViolation)
    {
        Phake::when($this->securityContext)->isGranted($this->role)->thenReturn($isGrantedNew);
        Phake::when($this->securityContext)->isGranted($this->oldRole)->thenReturn($isGrantedOld);

        $this->validator->validate($this->node, $this->constraint);

        Phake::verify($this->context, Phake::times($numberOfViolation))->addViolationAt('status', $this->message);
        Phake::verify($this->translator, Phake::times($numberOfViolation))->trans($this->constraint->message);
        Phake::verify($this->securityContext, Phake::atMost(2))->isGranted(Phake::anyParameters());
    }

    /**
     * @return array
     */
    public function provideGrantResponse()
    {
        return array(
            array(true, true, 0),
            array(true, false, 1),
            array(false, true, 1),
            array(false, false, 1),
        );
    }

    /**
     * @param bool $isGrantedOld
     * @param int  $violationTimes
     *
     * @dataProvider provideOldGrantResponse
     */
    public function testWhenStatusHasNoRole($isGrantedOld, $violationTimes)
    {
        Phake::when($this->status)->getToRole()->thenReturn(null);
        Phake::when($this->securityContext)->isGranted($this->oldRole)->thenReturn($isGrantedOld);

        $this->validator->validate($this->node, $this->constraint);

        Phake::verify($this->securityContext)->isGranted($this->oldRole);
        Phake::verify($this->context, Phake::times($violationTimes))->addViolationAt('status', $this->message);
        Phake::verify($this->translator, Phake::times($violationTimes))->trans($this->constraint->message);
    }

    /**
     * @return array
     */
    public function provideOldGrantResponse()
    {
        return array(
            array(true, 0),
            array(false, 1)
        );
    }
}
