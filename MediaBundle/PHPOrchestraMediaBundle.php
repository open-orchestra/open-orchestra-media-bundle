<?php

namespace PHPOrchestra\MediaBundle;

use PHPOrchestra\MediaBundle\DependencyInjection\CompilerPass\DisplayMediaCompilerPass;
use PHPOrchestra\MediaBundle\DependencyInjection\CompilerPass\ThumbnailCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class PHPOrchestraMediaBundle
 */
class PHPOrchestraMediaBundle extends Bundle
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
