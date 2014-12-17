<?php

namespace PHPOrchestra\ModelBundle\Validator\Constraints;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\ODM\MongoDB\DocumentManager;
use PHPOrchestra\ModelInterface\Model\StatusableInterface;

/**
 * Class PreventPublishedDocumentSaveValidator
 */
class PreventPublishedDocumentSaveValidator extends ConstraintValidator
{
    protected $translator;
    protected $documentManager;

    /**
     * @param Translator      $translator
     * @param DocumentManager $documentManager
     */
    public function __construct(Translator $translator, DocumentManager $documentManager)
    {
        $this->translator = $translator;
        $this->documentManager = $documentManager;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if ($value instanceof StatusableInterface) {
            $oldNode = $this->documentManager->getUnitOfWork()->getOriginalDocumentData($value);
            if (!empty($oldNode)) {
                $oldStatus = $oldNode['status'];
                if (!$oldStatus->isPublished()) {
                    return;
                }
            }

            $status = $value->getStatus();
            if (!empty($status) && $status->isPublished()) {
                $this->context->addViolation($this->translator->trans($constraint->message));
            }
        }
    }
}
