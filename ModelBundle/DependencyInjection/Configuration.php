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
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\ModelBundle\Document\Content')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\ContentRepository')->end()
                ->end()
            ->end()
            ->arrayNode('content_type')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\ModelBundle\Document\ContentType')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\ContentTypeRepository')->end()
                ->end()
            ->end()
            ->arrayNode('node')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\ModelBundle\Document\Node')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\NodeRepository')->end()
                ->end()
            ->end()
            ->arrayNode('site')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\ModelBundle\Document\Site')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\SiteRepository')->end()
                ->end()
            ->end()
            ->arrayNode('template')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\ModelBundle\Document\Template')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\TemplateRepository')->end()
                ->end()
            ->end()
            ->arrayNode('field_index')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\ModelBundle\Document\FieldIndex')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\FieldIndexRepository')->end()
                ->end()
            ->end()
            ->arrayNode('list_index')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\ModelBundle\Document\ListIndex')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\ListIndexRepository')->end()
                ->end()
            ->end()
            ->arrayNode('status')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\ModelBundle\Document\Status')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\StatusRepository')->end()
                ->end()
            ->end()
            ->arrayNode('theme')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\ModelBundle\Document\Theme')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\ThemeRepository')->end()
                ->end()
            ->end()
            ->arrayNode('media')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\ModelBundle\Document\Media')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\MediaRepository')->end()
                ->end()
            ->end()
            ->arrayNode('folder')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('class')->defaultValue('PHPOrchestra\ModelBundle\Document\Folder')->end()
                    ->scalarNode('repository')->defaultValue('PHPOrchestra\ModelBundle\Repository\FolderRepository')->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
