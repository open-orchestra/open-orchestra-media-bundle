<?php

namespace OpenOrchestra\BaseApiBundle\DependencyInjection;

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
     * @param string $tmp
     * @param string $fileSystem
     * @param int    $compression
     * @param array  $thumbnail
     *
     * @dataProvider provideConfig
     */
    public function testConfig($file, $domain, $tmp, $fileSystem, $compression, $thumbnail)
    {
        $container = $this->loadContainerFromFile($file);
        $this->assertEquals($domain, $container->getParameter('open_orchestra_media.media_domain'));
        $this->assertEquals($tmp, $container->getParameter('open_orchestra_media.tmp_dir'));
        $this->assertEquals($fileSystem, $container->getParameter('open_orchestra_media.filesystem'));
        $this->assertEquals($compression, $container->getParameter('open_orchestra_media.resize.compression_quality'));
        $this->assertEquals($thumbnail, $container->getParameter('open_orchestra_media.thumbnail.configuration'));

    }

    /**
     * @return array
     */
    public function provideConfig()
    {
        return array(
            array("empty", '', '/tmp', 'media_storage', 75,
                array(
                "max_height" => array("max_height" => 100),
                "max_width" => array("max_width" => 100),
                "rectangle" => array("max_width" => 100, "max_height" => 70),
                "media_thumbnail" => array("max_width" => 117, "max_height" => 117),
            )),
            array("value", 'fake_media_domain', 'fake_tmp', 'fake_media_system', 10000,
                array(
                "max_height" => array("max_height" => 5000),
                "max_width" => array("max_width" => 5000),
                "rectangle" => array("max_width" => 5000, "max_height" => 5000),
                "media_thumbnail" => array("max_width" => 117, "max_height" => 117),
            ))
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
