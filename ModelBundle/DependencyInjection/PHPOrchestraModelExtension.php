<?php

namespace PHPOrchestra\ModelBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class PHPOrchestraModelExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config as $class => $content) {
            if (is_array($content)) {
                $container->setParameter('php_orchestra_model.document.' . $class . '.class', $content['class']);
                if (array_key_exists('repository', $content)) {
                    if (array_key_exists('current_site', $content) && $content['current_site']) {
                        $container->register('php_orchestra_model.repository.' . $class, $content['repository'])
                            ->setFactoryService('doctrine.odm.mongodb.document_manager')
                            ->setFactoryMethod('getRepository')
                            ->addArgument($content['class'])
                            ->addMethodCall('setCurrentSiteManager', array(
                                new Reference('php_orchestra.manager.current_site')
                            ));
                    } else {
                        $container->register('php_orchestra_model.repository.' . $class, $content['repository'])
                            ->setFactoryService('doctrine.odm.mongodb.document_manager')
                            ->setFactoryMethod('getRepository')
                            ->addArgument($content['class']);
                    }
                }
            }
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('listener.yml');
        $loader->load('services.yml');
        $loader->load('validator.yml');
        $loader->load('manager.yml');
        $loader->load('form.yml');
        $loader->load('transformer.yml');
    }
}
