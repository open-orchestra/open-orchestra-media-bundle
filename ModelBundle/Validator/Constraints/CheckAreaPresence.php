<?php

namespace PHPOrchestra\ModelBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class CheckAreaPresence
 */
class CheckAreaPresence extends Constraint
{
    public $message = 'php_orchestra_model.area.presence_required';

    /**
     * @return string|void
     */
    public function validatedBy()
    {
        return 'check_area_presence';
    }

    /**
     * @return array|string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}
