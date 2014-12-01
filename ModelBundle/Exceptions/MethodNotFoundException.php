<?php

namespace PHPOrchestra\ModelBundle\Exceptions;

/**
 * Class MethodNotFoundException
 */

class MethodNotFoundException extends \Exception
{
    /**
     * @param string $method
     * @param string $class
     */
    public function __construct($method = "", $class = "")
    {
        parent::__construct(
            sprintf('Annotation Error : method %s is missing in class %s.', $method, $class)
        );
    }
}
