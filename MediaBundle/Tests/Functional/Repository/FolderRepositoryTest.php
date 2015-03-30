<?php

namespace OpenOrchestra\MediaBundle\Tests\Functional\Repository;

use Phake;
use OpenOrchestra\Media\Repository\FolderRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class FolderRepositoryTest
 */
class FolderRepositoryTest extends KernelTestCase
{
    /**
     * @var FolderRepositoryInterface
     */
    protected $repository;

    protected $siteManager;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        $this->siteManager = Phake::mock('OpenOrchestra\BaseBundle\Context\CurrentSiteIdInterface');

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('open_orchestra_media.repository.media_folder');
        $this->repository->setCurrentSiteManager($this->siteManager);
    }

    /**
     * @param string $siteId
     * @param int    $count
     *
     * @dataProvider provideSiteIdAndFolderCount
     */
    public function testFindAllRootFolderBySiteId($siteId, $count)
    {
        Phake::when($this->siteManager)->getCurrentSiteId()->thenReturn($siteId);

        $result = $this->repository->findAllRootFolderBySiteId();

        $this->assertCount($count, $result);
    }

    /**
     * @return array
     */
    public function provideSiteIdAndFolderCount()
    {
        return array(
            array('1', 2),
            array('2', 2),
            array('3', 2),
        );
    }
}
