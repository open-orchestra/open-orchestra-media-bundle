<?php

namespace PHPOrchestra\MediaBundle\DependencyInjection\CompilerPass;

use PHPOrchestra\BaseBundle\DependencyInjection\Compiler\AbstractTaggedCompiler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ThumbnailCompilerPass
 */
class ThumbnailCompilerPass extends AbstractTaggedCompiler implements CompilerPassInterface
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
        $managerName = 'php_orchestra_media.thumbnail_manager';
        $tagName = 'php_orchestra_media.thumbnail.strategy';

        $this->addStrategyToManager($container, $managerName, $tagName);
    }
}
