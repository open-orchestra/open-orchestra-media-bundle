<?php

namespace PHPOrchestra\MediaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('php_orchestra_media');

        $rootNode->children()
            ->scalarNode('upload_dir')->defaultNull()->end()
            ->scalarNode('no_image_available')->defaultValue('no_image_available.jpg')->end()
            ->arrayNode('media')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\MediaBundle\Document\Media')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\MediaBundle\Repository\MediaRepository')->end()
                ->end()
            ->end()
            ->arrayNode('media_folder')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\MediaBundle\Document\MediaFolder')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\MediaBundle\Repository\FolderRepository')->end()
                    ->booleanNode('current_site')->defaultTrue()->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
