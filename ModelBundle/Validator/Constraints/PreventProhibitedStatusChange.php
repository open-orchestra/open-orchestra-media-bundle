<?php

namespace PHPOrchestra\ModelBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class PreventProhibitedStatusChange
 */
class PreventProhibitedStatusChange extends Constraint
{
    public $message = 'php_orchestra_model.status.impossible_change';

    /**
     * @return string|void
     */
    public function validatedBy()
    {
        return 'prevent_prohibited_status_change';
    }

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
