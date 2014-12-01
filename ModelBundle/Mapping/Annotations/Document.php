<?php

namespace PHPOrchestra\ModelBundle\Mapping\Annotations;

use Doctrine\Common\Annotations\Annotation;
use PHPOrchestra\ModelBundle\Exceptions\PropertyNotFoundException;
use PHPOrchestra\ModelBundle\Exceptions\MethodNotFoundException;
use Symfony\Component\DependencyInjection\Container;

/**
 * @Annotation
 */
class Document extends Annotation
{
    protected $generatedField;
    protected $sourceField;
    protected $serviceName;
    protected $testMethod;

    /**
     * return service name
     *
     * @return string
     */
    public function getServiceName(){
        return $this->serviceName;
    }

    /**
     * return test method
     *
     * @return string
     */
    public function getTestMethod(){
        return $this->testMethod;
    }

    /**
     * Get source method
     *
     * @param string $target
     *
     * @return string
     */
    public function getSource($target)
    {
        return $this->getMethod($target, 'sourceField');
    }

    /**
     * Get generated method
     *
     * @param string $target
     *
     * @return string
     */
    public function getGenerated($target)
    {
        return $this->getMethod($target, 'generatedField');
    }

    /**
     * Get generated value
     *
     * @param string $target
     *
     */
    public function setGenerated($target)
    {
        return $this->getMethod($target, 'generatedField', 'set');
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
