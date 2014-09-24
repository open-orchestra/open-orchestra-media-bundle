<?php

namespace PHPOrchestra\ModelBundle\Validator\Constraints;

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
    protected $translator;

    /**
     * @param SecurityContextInterface $securityContext
     * @param Translator               $translator
     */
    public function __construct(SecurityContextInterface $securityContext, Translator $translator)
    {
        $this->securityContext = $securityContext;
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
        if (!is_null($value->getRole()) && !$this->securityContext->isGranted($value->getRole())) {
            $this->context->addViolation($this->translator->trans($constraint->message));
        }
    }
}
