<?php

namespace PHPOrchestra\IndexationBundle;

use PHPOrchestra\IndexationBundle\DependencyInjection\Compiler\IndexationCompilerPass;
use PHPOrchestra\IndexationBundle\DependencyInjection\Compiler\SearchCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PHPOrchestraIndexationBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new IndexationCompilerPass());
        $container->addCompilerPass(new SearchCompilerPass());
    }
}
