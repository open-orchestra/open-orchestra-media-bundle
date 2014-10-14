<?php

namespace PHPOrchestra\ModelBundle\Validator\Constraints;

use PHPOrchestra\ModelBundle\Repository\NodeRepository;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class StatusChangeValidator
 */
class StatusChangeValidator extends ConstraintValidator
{
    protected $securityContext;
    protected $nodeRepository;
    protected $translator;

    /**
     * @param SecurityContextInterface $securityContext
     * @param Translator               $translator
     * @param NodeRepository           $nodeRepository
     */
    public function __construct(
        SecurityContextInterface $securityContext,
        Translator $translator,
        NodeRepository $nodeRepository
    )
    {
        $this->securityContext = $securityContext;
        $this->nodeRepository = $nodeRepository;
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
        if (is_null($oldNode = $this->nodeRepository->find($value->getId()))) {
            return;
        }

        $oldStatus = $oldNode->getStatus();
        $status = $value->getStatus();

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
