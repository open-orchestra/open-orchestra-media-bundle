<?php

namespace PHPOrchestra\ModelInterface\Form\Type;

use Symfony\Component\Form\AbstractType;

/**
 * Class AbstractOrchestraStatusType
 */
abstract class AbstractOrchestraStatusType extends AbstractType
{
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'orchestra_status';
    }
}
