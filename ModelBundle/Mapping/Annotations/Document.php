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
    protected $generatedId;
    protected $sourceId;
    protected $serviceName;
    protected $existsName;
    protected $repository;

    /**
     * init repository
     *
     * @param Container $container
     */
    public function initRepository(Container $container){
        $this->repository = $container->get($this->serviceName);
    }

    /**
     * test exists
     *
     * @param string $id
     *
     * @return boolean
     */
    public function exists($id){
        $method = $this->existsName;
        return $this->repository->$method($id);
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
        return $this->getMethod($target, 'sourceId');
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
        return $this->getMethod($target, 'generatedId');
    }

    /**
     * Get generated value
     *
     * @param string $target
     *
     */
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
