<?php

namespace OpenOrchestra\MediaBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class TwigGlobalsCompilerPass
 */
class TwigGlobalsCompilerPass implements CompilerPassInterface
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
        if (
            $container->hasDefinition('twig')
            && $container->hasParameter('open_orchestra_media.allowed_mime_type')
        ) {
            $twig = $container->getDefinition('twig');
            $twig->addMethodCall(
                'addGlobal',
                array(
                    'media_allowed_mime_types',
                    $container->getParameter('open_orchestra_media.allowed_mime_type')
                )
            );
        }
    }
}
