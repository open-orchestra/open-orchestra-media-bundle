<?php
/**
 * Created by PhpStorm.
 * User: bfouche
 * Date: 28/07/14
 * Time: 15:54
 */

namespace PHPOrchestra\IndexationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class SolrConverterCompilerPass
 *
 * @package PHPOrchestra\IndexationBundle\DependencyInjection\Compiler
 */
class SolrConverterCompilerPass implements CompilerPassInterface
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
        if (!$container->hasDefinition('php_orchestra_indexation.solr_converter_manager')) {
            return;
        }

        $manager = $container->getDefinition('php_orchestra_indexation.solr_converter_manager');
        $strategies = $container->findTaggedServiceIds('php_orchestra_indexation.solr_converter.strategy');
        foreach ($strategies as $id => $attributes) {
            $manager->addMethodCall('addStrategy', array(new Reference($id)));
        }
    }
} 