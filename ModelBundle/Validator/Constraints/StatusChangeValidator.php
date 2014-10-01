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
        $oldNode = $this->nodeRepository->find($value->getId());
        $oldStatus = $oldNode->getStatus();

        $status = $value->getStatus();
        if ((!is_null($status->getToRole()) && !$this->securityContext->isGranted($status->getToRole()))
            || (!is_null($oldStatus->getFromRole()) && !$this->securityContext->isGranted($oldStatus->getFromRole()))
        ) {
            $this->context->addViolationAt('status', $this->translator->trans($constraint->message));
        }
    }
}
