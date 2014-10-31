<?php

namespace PHPOrchestra\ModelBundle\Validator\Constraints;

use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ODM\MongoDB\DocumentManager;

/**
 * Class PreventProhibitedStatusChangeValidator
 */
class PreventProhibitedStatusChangeValidator extends ConstraintValidator
{
    protected $securityContext;
    protected $documentManager;
    protected $translator;

    /**
     * @param SecurityContextInterface $securityContext
     * @param Translator               $translator
     * @param DocumentManager          $documentManager
     */
    public function __construct(
        SecurityContextInterface $securityContext,
        Translator $translator,
        DocumentManager $documentManager
    )
    {
        $this->securityContext = $securityContext;
        $this->documentManager = $documentManager;
        $this->translator = $translator;
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

        $toRoles = array();
        foreach ($status->getToRoles() as $toRole) {
            $toRoles[] = $toRole->getName();
        }

        $fromRoles = array();
        foreach ($oldStatus->getFromRoles() as $fromRole) {
            $fromRoles[] = $fromRole->getName();
        }

        if ((!empty($toRoles) && !$this->securityContext->isGranted($toRoles))
            || (!empty($fromRoles) && !$this->securityContext->isGranted($fromRoles))
        ) {
            $this->context->addViolationAt('status', $this->translator->trans($constraint->message));
        }
    }
}
