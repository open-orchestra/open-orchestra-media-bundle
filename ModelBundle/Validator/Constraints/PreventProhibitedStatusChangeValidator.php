<?php

namespace PHPOrchestra\ModelBundle\Validator\Constraints;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ODM\MongoDB\DocumentManager;
use PHPOrchestra\ModelBundle\Repository\RoleRepository;

/**
 * Class PreventProhibitedStatusChangeValidator
 */
class PreventProhibitedStatusChangeValidator extends ConstraintValidator
{
    protected $securityContext;
    protected $documentManager;
    protected $translator;
    protected $roleRepository;

    /**
     * @param SecurityContextInterface $securityContext
     * @param Translator               $translator
     * @param DocumentManager          $documentManager
     * @param RoleRepository           $roleRepository
     */
    public function __construct(
        SecurityContextInterface $securityContext,
        Translator $translator,
        DocumentManager $documentManager,
        RoleRepository $roleRepository
    )
    {
        $this->securityContext = $securityContext;
        $this->documentManager = $documentManager;
        $this->translator = $translator;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        $oldNode = $this->documentManager->getUnitOfWork()->getOriginalDocumentData($value);
        if (empty($oldNode)) {
            return;
        }

        $oldStatus = $oldNode['status'];
        $status = $value->getStatus();

        if ($oldStatus->getId() == $status->getId()) {
            return;
        }

        if (! $this->canSwitchStatus($oldStatus, $status)) {
            $this->context->addViolationAt('status', $this->translator->trans($constraint->message));
        }
    }

    /**
     * Check if current user is allowed to change content/node from fromStatus to toStatus
     * 
     * @param Status $fromStatus
     * @param Status $toStatus
     * 
     * @return boolean
     */
    public function canSwitchStatus($fromStatus, $toStatus)
    {
        $role = $this->roleRepository->findOneByFromStatusAndToStatus($fromStatus, $toStatus);

        if ($role) {
            return $this->securityContext->isGranted($role->getName());

        return false;
    }
}
