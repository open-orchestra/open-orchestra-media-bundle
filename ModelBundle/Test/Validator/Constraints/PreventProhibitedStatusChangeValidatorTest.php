<?php

namespace PHPOrchestra\ModelBundle\Test\Validator\Constraints;

use Doctrine\Common\Collections\ArrayCollection;
use Phake;
use PHPOrchestra\ModelBundle\Validator\Constraints\PreventProhibitedStatusChange;
use PHPOrchestra\ModelBundle\Validator\Constraints\PreventProhibitedStatusChangeValidator;

/**
 * Class PreventProhibitedStatusChangeValidatorTest
 */
class PreventProhibitedStatusChangeValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PreventProhibitedStatusChangeValidator
     */
    protected $validator;

    protected $message = 'message';
    protected $statusRepository;
    protected $securityContext;
    protected $documentManager;
    protected $oldRoleName;
    protected $translator;
    protected $constraint;
    protected $unitOfWork;
    protected $oldStatus;
    protected $roleName;
    protected $oldRoles;
    protected $oldRole;
    protected $oldNode;
    protected $context;
    protected $status;
    protected $roles;
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
        $this->constraint = new PreventProhibitedStatusChange();
        $this->context = Phake::mock('Symfony\Component\Validator\Context\ExecutionContext');

        $this->roleName = 'ROLE';
        $this->role = Phake::mock('PHPOrchestra\ModelBundle\Document\Role');
        Phake::when($this->role)->getName()->thenReturn($this->roleName);
        $this->roles = new ArrayCollection();
        $this->roles->add($this->role);
        $this->status = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusInterface');
        Phake::when($this->status)->getToRoles()->thenReturn($this->roles);
        Phake::when($this->status)->getId()->thenReturn('newId');

        $this->node = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        Phake::when($this->node)->getStatus()->thenReturn($this->status);

        $this->oldRoleName = 'OLD_ROLE';
        $this->oldRole = Phake::mock('PHPOrchestra\ModelBundle\Document\Role');
        Phake::when($this->oldRole)->getName()->thenReturn($this->oldRoleName);
        $this->oldRoles = new ArrayCollection();
        $this->oldRoles->add($this->oldRole);
        $this->oldStatus = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusInterface');
        Phake::when($this->oldStatus)->getFromRoles()->thenReturn($this->oldRoles);
        Phake::when($this->oldStatus)->getId()->thenReturn('oldId');

        $this->oldNode = array('status' => $this->oldStatus);

        $this->unitOfWork = Phake::mock('Doctrine\ODM\MongoDB\UnitOfWork');
        Phake::when($this->unitOfWork)->getOriginalDocumentData(Phake::anyParameters())->thenReturn($this->oldNode);
        $this->documentManager = Phake::mock('Doctrine\ODM\MongoDB\DocumentManager');
        Phake::when($this->documentManager)->getUnitOfWork()->thenReturn($this->unitOfWork);

        $this->validator = new PreventProhibitedStatusChangeValidator($this->securityContext, $this->translator, $this->documentManager);
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
        Phake::when($this->securityContext)->isGranted(array($this->roleName))->thenReturn($isGrantedNew);
        Phake::when($this->securityContext)->isGranted(array($this->oldRoleName))->thenReturn($isGrantedOld);

        $this->validator->validate($this->node, $this->constraint);

        Phake::verify($this->securityContext, Phake::atMost(1))->isGranted(array($this->roleName));
        Phake::verify($this->securityContext, Phake::atMost(1))->isGranted(array($this->oldRoleName));
        Phake::verify($this->context, Phake::times($numberOfViolation))->addViolationAt('status', $this->message);
        Phake::verify($this->translator, Phake::times($numberOfViolation))->trans($this->constraint->message);
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
        $roles = new ArrayCollection();
        Phake::when($this->status)->getToRoles()->thenReturn($roles);
        Phake::when($this->securityContext)->isGranted(array($this->oldRoleName))->thenReturn($isGrantedOld);

        $this->validator->validate($this->node, $this->constraint);

        Phake::verify($this->securityContext)->isGranted(array($this->oldRoleName));
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

    /**
     * Test on node creation
     */
    public function testWhenNoOldNode()
    {
        Phake::when($this->unitOfWork)->getOriginalDocumentData(Phake::anyParameters())->thenReturn(array());

        $this->validator->validate($this->node, $this->constraint);

        Phake::verify($this->context, Phake::never())->addViolationAt(Phake::anyParameters());
    }

    /**
     * Test on node creation
     */
    public function testWhenStatusTheSame()
    {
        Phake::when($this->status)->getId()->thenReturn('newId');
        Phake::when($this->oldStatus)->getId()->thenReturn('newId');

        $this->validator->validate($this->node, $this->constraint);

        Phake::verify($this->context, Phake::never())->addViolationAt(Phake::anyParameters());
    }
}
