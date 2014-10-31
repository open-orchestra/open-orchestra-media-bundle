<?php

namespace PHPOrchestra\ModelBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class PreventPublishedDocumentSave
 */
class PreventPublishedDocumentSave extends Constraint
{
    public $message = 'php_orchestra_model.document.impossible_save';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'prevent_published_document_save';
    }

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
