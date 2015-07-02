<?php

namespace OpenOrchestra\MediaModelBundle;

use OpenOrchestra\MediaModelBundle\DependencyInjection\Compiler\EntityResolverCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class OpenOrchestraMediaModelBundle
 */
class OpenOrchestraMediaModelBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new EntityResolverCompilerPass());
    }
}
