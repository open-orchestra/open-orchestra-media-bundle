<?php

namespace PHPOrchestra\ModelBundle\Test\Manager;

use Phake;
use PHPOrchestra\ModelBundle\Manager\NodeManager;
use PHPOrchestra\ModelInterface\Model\NodeInterface;

/**
 * Class NodeManagerTest
 */
class NodeManagerTest extends \PHPUnit_Framework_TestCase
{
    protected $manager;

    protected $nodeClass;

    /**
     * set up the test
     */
    public function setUp()
    {
        $this->nodeClass = 'PHPOrchestra\ModelBundle\Document\Node';

        $this->manager = new NodeManager($this->nodeClass);
    }

    /**
     * @param string $language
     * @param string $siteId
     *
     * @dataProvider provideLanguageAndSite
     */
    public function testCreateTransverseNode($language, $siteId)
    {
        $node = $this->manager->createTransverseNode($language, $siteId);

        $this->assertInstanceOf('PHPOrchestra\ModelInterface\Model\NodeInterface', $node);
        $this->assertSame($siteId, $node->getSiteId());
        $this->assertSame(NodeInterface::TRANSVERSE_NODE_ID, $node->getNodeId());
        $this->assertSame(NodeInterface::TRANSVERSE_NODE_ID, $node->getName());
        $this->assertSame(1, $node->getVersion());
        $this->assertSame($language, $node->getLanguage());
        $this->assertCount(1, $node->getAreas());
        $area = $node->getAreas()->first();
        $this->assertSame('main', $area->getLabel());
        $this->assertSame('main', $area->getAreaId());
    }

    /**
     * @return array
     */
    public function provideLanguageAndSite()
    {
        return array(
            array('fr', '1'),
            array('en', '1'),
            array('fr', '2'),
            array('en', '2'),
        );
    }
}
