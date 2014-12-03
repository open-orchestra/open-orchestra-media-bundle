<?php

namespace PHPOrchestra\ModelBundle\FunctionalTest\Repository;

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
     * @param string $siteId
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
     * @param int    $version
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
            array('2', 11, 1),
            array('3', 10, 1),
        );
    }

    /**
     * @param string        $language
     * @param int           $version
     * @param string        $siteId
     * @param NodeInterface $node
     * @param string        $nodeId
     */
    protected function assertSameNode($language, $version, $siteId, $node, $nodeId = NodeInterface::ROOT_NODE_ID)
    {
        $this->assertInstanceOf('PHPOrchestra\ModelBundle\Model\NodeInterface', $node);
        $this->assertSame($nodeId, $node->getNodeId());
        $this->assertSame($language, $node->getLanguage());
        $this->assertSame($version, $node->getVersion());
        $this->assertSame($siteId, $node->getSiteId());
        $this->assertSame(false, $node->getDeleted());
    }

    /**
     * @param string      $siteId
     * @param int         $nodeNumber
     * @param int         $version
     * @param string      $language
     * @param string|null $nodeId
     *
     * @dataProvider provideForGetFooter()
     */
    public function testGetFooterTree($siteId, $nodeNumber, $version, $language = 'fr', $nodeId = null)
    {
        Phake::when($this->currentSiteManager)->getCurrentSiteId()->thenReturn($siteId);
        Phake::when($this->currentSiteManager)->getCurrentSiteDefaultLanguage()->thenReturn($language);

        $nodes = $this->repository->getFooterTree($language);

        $this->assertCount($nodeNumber, $nodes);
        if ($nodeId) {
            $this->assertSameNode($language, $version, $siteId, $nodes[$nodeId], $nodeId);
            $this->assertSame('published', $nodes[$nodeId]->getStatus()->getName());
        }
    }

    /**
     * @return array
     */
    public function provideForGetFooter()
    {
        return array(
            array('1', 6, 1, 'fr', 'fixture_about_us'),
            array('1', 0, 1, 'en'),
            array('2', 0, 1),
            array('3', 8, 1, 'fr', NodeInterface::ROOT_NODE_ID),
            array('3', 8, 1, 'en', NodeInterface::ROOT_NODE_ID),
        );
    }

    /**
     * @param string      $siteId
     * @param int         $nodeNumber
     * @param int         $version
     * @param string      $language
     *
     * @dataProvider provideForGetMenu()
     */
    public function testGetMenuTree($siteId, $nodeNumber, $version, $language = 'fr')
    {
        Phake::when($this->currentSiteManager)->getCurrentSiteId()->thenReturn($siteId);
        Phake::when($this->currentSiteManager)->getCurrentSiteDefaultLanguage()->thenReturn($language);

        $nodes = $this->repository->getMenuTree($language);

        $this->assertCount($nodeNumber, $nodes);
        $this->assertSameNode($language, $version, $siteId, $nodes[NodeInterface::ROOT_NODE_ID]);
        $this->assertSame('published', $nodes[NodeInterface::ROOT_NODE_ID]->getStatus()->getName());
    }

    /**
     * @return array
     */
    public function provideForGetMenu()
    {
        return array(
            array('1', 8, 2, 'fr'),
            array('1', 1, 1, 'en'),
            array('2', 5, 1, 'fr'),
            array('3', 8, 1, 'fr'),
            array('3', 8, 1, 'en'),
        );
    }

    /**
     * @param string      $nodeId
     * @param int         $nbLevel
     * @param int         $nodeNumber
     * @param int         $version
     * @param string      $siteId
     * @param string|null $local
     *
     * @dataProvider provideForGetSubMenu
     */
    public function testGetSubMenu($nodeId, $nbLevel, $nodeNumber, $version, $siteId, $local = null)
    {
        Phake::when($this->currentSiteManager)->getCurrentSiteId()->thenReturn($siteId);

        $nodes = $this->repository->getSubMenu($nodeId, $nbLevel, $local);

        $this->assertCount($nodeNumber, $nodes);

        if ($local) {
            $this->assertSameNode($local, $version, $siteId, $nodes[0], $nodeId);
        } else {
            $this->assertSameNode('fr', $version, $siteId, $nodes[0], $nodeId);
        }

        $this->assertSame('published', $nodes[0]->getStatus()->getName());
    }

    /**
     * @return array
     */
    public function provideForGetSubMenu()
    {
        return array(
            array('fixture_about_us', 1, 3, 1, '1', 'fr'),
            array(NodeInterface::ROOT_NODE_ID, 1, 8, 2, '1', 'fr'),
            array(NodeInterface::ROOT_NODE_ID, 0, 6, 2, '1', 'fr'),
            array(NodeInterface::ROOT_NODE_ID, 1, 1, 1, '1', 'en'),
            array(NodeInterface::ROOT_NODE_ID, 0, 6, 2, '1'),
            array(NodeInterface::ROOT_NODE_ID, 1, 11, 1, '2', 'fr'),
            array(NodeInterface::ROOT_NODE_ID, 1, 11, 1, '2'),
            array(NodeInterface::ROOT_NODE_ID, 1, 10, 1, '3', 'fr'),
            array(NodeInterface::ROOT_NODE_ID, 0, 6, 1, '3', 'fr'),
            array('espace_Cardif', 0, 5, 1, '3', 'fr'),
            array('espace_Cardif', 0, 5, 1, '3', 'en'),
            array(NodeInterface::ROOT_NODE_ID, 1, 10, 1, '3'),
        );
    }
}
