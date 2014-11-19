<?php

namespace PHPOrchestra\ModelBundle\Test\Repository;

use Phake;
use PHPOrchestra\ModelBundle\Model\NodeInterface;
use PHPOrchestra\ModelBundle\Repository\NodeRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class NodeRepositoryTest
 */
class NodeRepositoryTest extends KernelTestCase
{
    /**
     * @var NodeRepository
     */
    protected $repository;

    protected $currentSiteManager;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        $this->currentSiteManager = Phake::mock('PHPOrchestra\BaseBundle\Context\CurrentSiteIdInterface');
        Phake::when($this->currentSiteManager)->getCurrentSiteId()->thenReturn('1');
        Phake::when($this->currentSiteManager)->getCurrentSiteDefaultLanguage()->thenReturn('fr');

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('php_orchestra_model.repository.node');
        $this->repository->setCurrentSiteManager($this->currentSiteManager);
    }

    /**
     * @param string $language
     * @param int    $version
     * @param string $siteId
     *
     * @dataProvider provideLanguageLastVersionAndSiteId
     */
    public function testFindOneByNodeIdAndLanguageWithPublishedAndLastVersionAndSiteId($language, $version, $siteId)
    {
        Phake::when($this->currentSiteManager)->getCurrentSiteId()->thenReturn($siteId);

        $node = $this->repository->findOneByNodeIdAndLanguageWithPublishedAndLastVersionAndSiteId(NodeInterface::ROOT_NODE_ID, $language);

        $this->assertSameNode($language, $version, $siteId, $node);
    }

    /**
     * @return array
     */
    public function provideLanguageLastVersionAndSiteId()
    {
        return array(
            array('en', 1, '1'),
            array('fr', 2, '1'),
            array('fr', 1, '3'),
            array('en', 1, '3'),
            array('fr', 1, '2'),
        );
    }

    /**
     * @param $language
     * @param $version
     * @param $siteId
     *
     * @dataProvider provideLanguageLastVersionAndSiteId
     */
    public function testFindOneByNodeIdAndLanguageAndVersionAndSiteIdWithPublishedDataSet($language, $version, $siteId)
    {
        Phake::when($this->currentSiteManager)->getCurrentSiteId()->thenReturn($siteId);

        $node = $this->repository->findOneByNodeIdAndLanguageAndVersionAndSiteId(NodeInterface::ROOT_NODE_ID, $language, $version);

        $this->assertSameNode($language, $version, $siteId, $node);
    }

    /**
     * @param string $language
     * @param int    $version
     * @param string $siteId
     * @param int    $versionExpected
     *
     * @dataProvider provideLanguageLastVersionAndSiteIdNotPublished
     */
    public function testFindOneByNodeIdAndLanguageAndVersionAndSiteIdWithNotPublishedDataSet($language, $version = null, $siteId, $versionExpected)
    {
        Phake::when($this->currentSiteManager)->getCurrentSiteId()->thenReturn($siteId);

        $node = $this->repository->findOneByNodeIdAndLanguageAndVersionAndSiteId(NodeInterface::ROOT_NODE_ID, $language, $version);

        $this->assertSameNode($language, $versionExpected, $siteId, $node);
        $this->assertSame('draft', $node->getStatus()->getName());
    }

    /**
     * @return array
     */
    public function provideLanguageLastVersionAndSiteIdNotPublished()
    {
        return array(
            array('fr', 3, '1', 3),
            array('fr', null, '1', 3),
        );
    }

    /**
     * @param string $language
     * @param int    $version
     * @param string $siteId
     * @param int    $versionExpected
     *
     * @dataProvider provideLanguageLastVersionAndSiteIdNotPublished
     */
    public function testFindOneByNodeIdAndLanguageAndSiteIdAndLastVersion($language, $version = null, $siteId, $versionExpected)
    {
        Phake::when($this->currentSiteManager)->getCurrentSiteId()->thenReturn($siteId);

        $node = $this->repository->findOneByNodeIdAndLanguageAndSiteIdAndLastVersion(NodeInterface::ROOT_NODE_ID, $language);

        $this->assertSameNode($language, $versionExpected, $siteId, $node);
    }

    /**
     * Test last version
     */
    public function testFindOneByNodeIdAndSiteIdAndLastVersion()
    {
        $node = $this->repository->findOneByNodeIdAndSiteIdAndLastVersion(NodeInterface::ROOT_NODE_ID);

        $this->assertSameNode('fr', 3, '1', $node);
    }

    /**
     * @param array  $versions
     * @param string $language
     *
     * @dataProvider provideLanguageAndVersionListAndSiteId
     */
    public function testFindByNodeIdAndLanguageAndSiteId(array $versions, $language, $siteId)
    {
        Phake::when($this->currentSiteManager)->getCurrentSiteId()->thenReturn($siteId);

        $nodes = $this->repository->findByNodeIdAndLanguageAndSiteId(NodeInterface::ROOT_NODE_ID, $language);

        $this->assertCount(count($versions), $nodes);
        foreach ($nodes as $node) {
            $this->assertSameNode($language, array_shift($versions), $siteId, $node);
        }

    }

    /**
     * @return array
     */
    public function provideLanguageAndVersionListAndSiteId()
    {
        return array(
            array(array(1), 'en', '1'),
            array(array(1, 2, 3), 'fr', '1'),
            array(array(1), 'fr', '2'),
            array(array(1), 'fr', '3'),
            array(array(1), 'en', '3'),
        );
    }

    /**
     * @param string $siteId
     * @param int    $nodeNumber
     *
     * @dataProvider provideSiteIdAndNumberOfNode
     */
    public function testFindLastVersionBySiteId($siteId, $nodeNumber, $version)
    {
        Phake::when($this->currentSiteManager)->getCurrentSiteId()->thenReturn($siteId);

        $nodes = $this->repository->findLastVersionBySiteId();

        $this->assertCount($nodeNumber, $nodes);
        $this->assertSameNode('fr', $version, $siteId, $nodes[NodeInterface::ROOT_NODE_ID]);
    }

    /**
     * @return array
     */
    public function provideSiteIdAndNumberOfNode()
    {
        return array(
            array('1', 8, 3),
            array('2', 12, 1),
            array('3', 10, 1),
        );
    }

    /**
     * @param $language
     * @param $version
     * @param $siteId
     * @param $node
     */
    protected function assertSameNode($language, $version, $siteId, $node)
    {
        $this->assertInstanceOf('PHPOrchestra\ModelBundle\Model\NodeInterface', $node);
        $this->assertSame(NodeInterface::ROOT_NODE_ID, $node->getNodeId());
        $this->assertSame($language, $node->getLanguage());
        $this->assertSame($version, $node->getVersion());
        $this->assertSame($siteId, $node->getSiteId());
    }
}
