<?php

namespace PHPOrchestra\ModelBundle\Mapping\Annotations;

use Doctrine\Common\Annotations\Annotation;
use PHPOrchestra\ModelBundle\Exceptions\PropertyNotFoundException;
use PHPOrchestra\ModelBundle\Exceptions\MethodNotFoundException;

/** @Annotation */
class Document extends Annotation
{
    protected $generatedId;
    protected $sourceId;

    public function getGeneratedId(){
        return $this->generatedId;
    }

    public function getSourceId(){
        return $this->sourceId;
    }

    public function getSource($target)
    {
        return $this->getMethod($target, 'sourceId');
    }

    public function getGenerated($target)
    {
        return $this->getMethod($target, 'generatedId');
    }

    public function setGenerated($target)
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
