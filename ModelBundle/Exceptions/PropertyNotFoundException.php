<?php

namespace PHPOrchestra\ModelBundle\Exceptions;
use Exception;

/**
 * Class PropertyNotFoundException
 */
class PropertyNotFoundException extends \Exception
{
    /**
     * @param string     $property
     * @param string     $class
     */
    public function __construct($property = "", $class = "")
    {
        parent::__construct(
            sprintf('Annotation Error : property %s is missing in annotation for class %s.', $property, $class)
        );
    }

}
