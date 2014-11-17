<?php

namespace PHPOrchestra\ModelBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class DisplayMediaCompilerPass
 */
class DisplayMediaCompilerPass implements CompilerPassInterface
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
        if (!$container->hasDefinition('php_orchestra_model.thumbnail_manager')) {
            return;
        }

        $manager = $container->getDefinition('php_orchestra_model.display_media_manager');
        $strategies = $container->findTaggedServiceIds('php_orchestra_model.display_media.strategy');
        foreach ($strategies as $id => $attributes) {
            $manager->addMethodCall('addStrategy', array(new Reference($id)));
        }
    }
}
