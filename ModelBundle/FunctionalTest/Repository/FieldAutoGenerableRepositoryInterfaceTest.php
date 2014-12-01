<?php

namespace PHPOrchestra\ModelBundle\FunctionalTest\Repository;

use Phake;
use PHPOrchestra\ModelBundle\Repository\FieldAutoGenerableRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class FieldAutoGenerableRepositoryInterfaceTest
 */
class FieldAutoGenerableRepositoryInterfaceTest extends KernelTestCase
{
    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
    }

    /**
     * @param string $serviceName
     *
     * @dataProvider provideServiceName
     */
    public function testImplementFieldAutoGenerableRepositoryInterface($serviceName)
    {
        $repository = static::$kernel->getContainer()->get($serviceName);

        $this->assertInstanceOf('PHPOrchestra\ModelBundle\Repository\FieldAutoGenerableRepositoryInterface', $repository);
    }

    /**
     * @return array
     */
    public function provideServiceName()
    {
        return array(
            array('php_orchestra_model.repository.node'),
            array('php_orchestra_model.repository.template'),
            array('php_orchestra_model.repository.content'),
        );
    }
}
