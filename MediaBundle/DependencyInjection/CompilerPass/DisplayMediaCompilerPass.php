<?php

namespace PHPOrchestra\MediaBundle\DependencyInjection\CompilerPass;

use PHPOrchestra\BaseBundle\DependencyInjection\Compiler\AbstractTaggedCompiler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class DisplayMediaCompilerPass
 */
class DisplayMediaCompilerPass extends AbstractTaggedCompiler implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $managerName = 'php_orchestra_media.display_media_manager';
        $tagName = 'php_orchestra_media.display_media.strategy';

        $this->addStrategyToManager($container, $managerName, $tagName);
    }
}
