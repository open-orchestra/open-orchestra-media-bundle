<?php

namespace OpenOrchestra\MediaBundle;

use OpenOrchestra\MediaBundle\DependencyInjection\CompilerPass\DisplayMediaCompilerPass;
use OpenOrchestra\MediaBundle\DependencyInjection\CompilerPass\TwigGlobalsCompilerPass;
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

        $container->addCompilerPass(new DisplayMediaCompilerPass());
        $container->addCompilerPass(new TwigGlobalsCompilerPass());
    }
}
