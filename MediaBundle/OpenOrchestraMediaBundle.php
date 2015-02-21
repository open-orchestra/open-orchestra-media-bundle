<?php

namespace OpenOrchestra\MediaBundle;

use OpenOrchestra\MediaBundle\DependencyInjection\CompilerPass\DisplayMediaCompilerPass;
use OpenOrchestra\MediaBundle\DependencyInjection\CompilerPass\ThumbnailCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class OpenOrchestraMediaBundle
 */
class OpenOrchestraMediaBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ThumbnailCompilerPass());
        $container->addCompilerPass(new DisplayMediaCompilerPass());
    }
}
