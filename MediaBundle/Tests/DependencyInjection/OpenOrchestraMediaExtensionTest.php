<?php

namespace OpenOrchestra\MediaBundle\DependencyInjection;

use OpenOrchestra\MediaBundle\DependencyInjection\OpenOrchestraMediaExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class OpenOrchestraMediaExtensionTest
 */
class OpenOrchestraMediaExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $file
     * @param string $domain
     * @param string $fileSystem
     *
     * @dataProvider provideConfig
     */
    public function testConfig($file, $domain, $fileSystem)
    {
        $container = $this->loadContainerFromFile($file);

        $this->assertEquals($domain, $container->getParameter('open_orchestra_media.media_domain'));
        $this->assertEquals($fileSystem, $container->getParameter('open_orchestra_media.filesystem'));
    }

    /**
     * @return array
     */
    public function provideConfig()
    {
        return array(
            array('empty', '', 'media_storage'),
            array('value', 'fake_media_domain', 'fake_media_system')
        );
    }

    /**
     * @param string $file
     *
     * @return ContainerBuilder
     */
    private function loadContainerFromFile($file)
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.debug', false);
        $container->setParameter('kernel.cache_dir', '/tmp');
        $container->setParameter('kernel.bundles', array());
        $container->registerExtension(new OpenOrchestraMediaExtension());

        $locator = new FileLocator(__DIR__ . '/Fixtures/config/');
        $loader = new YamlFileLoader($container, $locator);
        $loader->load($file . '.yml');
        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->compile();

        return $container;
    }
}
