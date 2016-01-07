<?php

namespace OpenOrchestra\BaseApiBundle\DependencyInjection;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractBaseTestCase;
use OpenOrchestra\MediaModelBundle\DependencyInjection\OpenOrchestraMediaModelExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class OpenOrchestraMediaModelExtensionTest
 */
class OpenOrchestraMediaModelExtensionTest extends AbstractBaseTestCase
{
    /**
     * @param string     $file
     * @param string     $class
     * @param string     $name
     * @param string     $repository
     *
     * @dataProvider provideDocumentClass
     */
    public function testConfig($file, $class, $name, $repository)
    {
        $container = $this->loadContainerFromFile($file);
        $this->assertEquals($class, $container->getParameter('open_orchestra_media.document.' . $name . '.class'));
        $this->assertDefinition($container->getDefinition('open_orchestra_media.repository.' . $name), $class, $repository);
    }

    /**
     * @return array
     */
    public function provideDocumentClass()
    {
        return array(
            array("empty", "OpenOrchestra\\MediaModelBundle\\Document\\Media", "media", "OpenOrchestra\\MediaModelBundle\\Repository\\MediaRepository"),
            array("empty", "OpenOrchestra\\MediaModelBundle\\Document\\MediaFolder", "media_folder", "OpenOrchestra\\MediaModelBundle\\Repository\\FolderRepository"),
            array("value", "FakeClassMedia", "media", "FakeRepositoryMedia"),
            array("value", "FakeClassMediaFolder", "media_folder", "FakeRepositoryMediaFolder")
        );
    }

    /**
     * @param Definition $definition
     * @param string     $class
     * @param string     $repository
     */
    private function assertDefinition(Definition $definition, $class, $repository)
    {
        $this->assertSame($definition->getClass(), $repository);
        $factory = $definition->getFactory();
        $this->assertSame($factory[1], "getRepository");
        $this->assertSame($definition->getArgument(0), $class);
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
        $container->registerExtension(new OpenOrchestraMediaModelExtension());

        $locator = new FileLocator(__DIR__ . '/Fixtures/config/');
        $loader = new YamlFileLoader($container, $locator);
        $loader->load($file . '.yml');
        $container->getCompilerPassConfig()->setOptimizationPasses(array());
        $container->getCompilerPassConfig()->setRemovingPasses(array());
        $container->compile();

        return $container;
    }
}
