<?php

namespace PHPOrchestra\ModelBundle\Mapping\Annotations;

use Doctrine\Common\Annotations\Annotation;
use PHPOrchestra\ModelBundle\Exceptions\PropertyNotFoundException;
use PHPOrchestra\ModelBundle\Exceptions\MethodNotFoundException;

/** @Annotation */
final class Document extends Annotation
{
    public $generatedId;
    public $sourceId;

    public function getSourceId($target)
    {
        return $this->getMethod($target, 'sourceId');
    }

    public function getGeneratedId($target)
    {
        return $this->getMethod($target, 'generatedId');
    }

    public function setGeneratedId($target)
    {
        return $this->getMethod($target, 'generatedId', 'set');
    }

    protected function getMethod($target, $property, $pre = 'get')
    {
        if(isset($this->$property)){
            $method = $pre . ucfirst($this->$property);
            if(method_exists($target, $method)){
                return $method;
            }
            else {
                throw new MethodNotFoundException($method, get_class($target));
            }
        }
        else {
            throw new PropertyNotFoundException($property, get_class($target));
        }
    }
}
