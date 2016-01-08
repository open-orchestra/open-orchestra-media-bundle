<?php

namespace OpenOrchestra\MediaBundle\DependencyInjection;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractBaseTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class OpenOrchestraMediaExtensionTest
 */
class OpenOrchestraMediaExtensionTest extends AbstractBaseTestCase
{
    /**
     * @param string $file
     * @param string $domain
     *
     * @dataProvider provideConfig
     */
    public function testConfig($file, $domain)
    {
        $container = $this->loadContainerFromFile($file);

        $this->assertEquals($domain, $container->getParameter('open_orchestra_media.media_domain'));
    }

    /**
     * @return array
     */
    public function provideConfig()
    {
        return array(
            array('empty', ''),
            array('value', 'fake_media_domain')
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
