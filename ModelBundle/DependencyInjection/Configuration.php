<?php

namespace PHPOrchestra\ModelBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class
 * }
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('php_orchestra_model');

        $rootNode->children()
            ->arrayNode('content')
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestraModelBundle:Content')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\ContentRepository')->end()
                ->end()
            ->end()
            ->arrayNode('content_type')
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestraModelBundle:ContentType')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\ContentTypeRepository')->end()
                ->end()
            ->end()
            ->arrayNode('node')
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestraModelBundle:Node')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\NodeRepository')->end()
                ->end()
            ->end()
            ->arrayNode('site')
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestraModelBundle:Site')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\SiteRepository')->end()
                ->end()
            ->end()
            ->arrayNode('template')
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestraModelBundle:Template')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\TemplateRepository')->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
