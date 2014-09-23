<?php

namespace PHPOrchestra\ModelBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class StatusChange
 */
class StatusChange extends Constraint
{
    public $message = 'php_orchestra_model.status.impossible_change';

    /**
     * @return string|void
     */
    public function validatedBy()
    {
        return 'status_change';
    }

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
