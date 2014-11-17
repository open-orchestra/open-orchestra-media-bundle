<?php

namespace PHPOrchestra\ModelBundle;

use PHPOrchestra\ModelBundle\DependencyInjection\CompilerPass\DisplayMediaCompilerPass;
use PHPOrchestra\ModelBundle\DependencyInjection\CompilerPass\ThumbnailCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class PHPOrchestraModelBundle
 */
class PHPOrchestraModelBundle extends Bundle
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
