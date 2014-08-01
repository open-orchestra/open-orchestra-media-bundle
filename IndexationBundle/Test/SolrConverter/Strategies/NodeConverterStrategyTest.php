<?php

namespace PHPOrchestra\IndexationBundle\Test\SolrConverter\Strategies;

use PHPOrchestra\IndexationBundle\SolrConverter\Strategies\NodeConverterStrategy;
use Phake;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class NodeConverterStrategyTest
 */
class NodeConverterStrategyTest extends \PHPUnit_Framework_TestCase
{

    protected $strategies;
    protected $strategy;
    protected $router;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->strategies = array('content');

        $this->router = Phake::mock('PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlGenerator');

        $this->strategy = new NodeConverterStrategy($this->router);
    }

    /**
     * Assert that the strategy is supported
     */
    public function testSupport()
    {
        $node = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        $this->assertTrue($this->strategy->support($node));
    }

    /**
     * test the strategy with another object
     */
    public function testDoesNotSupport()
    {
        $fieldIndex = Phake::mock('PHPOrchestra\ModelBundle\Model\ContentInterface');
        $this->assertFalse($this->strategy->support($fieldIndex));
    }

    /**
     * @param array $fields
     *
     * @dataProvider provideFields
     */
    public function testToSolrDocument($fields)
    {
        $document = Phake::mock('Solarium\QueryType\Update\Query\Document\Document');
        $node = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        $update = Phake::mock('Solarium\QueryType\Update\Query\Query');
        Phake::when($update)->createDocument()->thenReturn($document);

        $this->assertSame($document, $this->strategy->toSolrDocument($node, $fields, $update));

        Phake::verify($update)->createDocument();
        Phake::verify($node)->getNodeId();
        Phake::verify($node)->getAlias();
        Phake::verify($node)->getName();
        Phake::verify($node)->getVersion();
        Phake::verify($node)->getLanguage();
        Phake::verify($node)->getNodeType();
        Phake::verify($node)->getParentId();
        Phake::verify($node)->getStatus();
        Phake::verify($node)->getPath();
    }

    /**
     * @return array
     */
    public function provideFields()
    {
        return array(
            array(
                array(
                    'title_s' => array('titre 1'),
                    'title_t' => array('titre 2'),
                    'author_s' => array('l autheur'),
                    'text_t' => array('le texte')
                )
            ),
            array(
                array(
                    'image_s' => array('image 1', 'image 2'),
                    'complement_t' => array('le premier', 'second', 'et troisième')
                )
            )
        );
    }

    /**
     * Test get content
     */
    public function testGetContent()
    {
        $fieldName = 'title';
        $node = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        $block = Phake::mock('PHPOrchestra\ModelBundle\Model\BlockInterface');

        Phake::when($node)->getBlocks()->thenReturn(array($block, $block));
        Phake::when($block)->getAttributes()->thenReturn(array($fieldName => 'test', 'author' => 'moi'));

        $this->assertSame('test', $this->strategy->getContent($node, $fieldName, false));

        Phake::verify($node)->getBlocks();
        Phake::verify($block)->getAttributes();
    }

    /**
     * @param string $nodeId
     *
     * @dataProvider provideNodeId
     */
    public function testGenerateUrl($nodeId)
    {
        $absoluteUrl = 'http://phporchestra.dev/app_dev/'.$nodeId;
        $node = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
        Phake::when($node)->getNodeId()->thenReturn($nodeId);
        Phake::when($this->router)->generate(Phake::anyParameters())->thenReturn($absoluteUrl);

        $this->assertSame($absoluteUrl, $this->strategy->generateUrl($node));

        Phake::verify($node)->getNodeId();
        Phake::verify($this->router)->generate($nodeId, array(), UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @return array
     */
    public function provideNodeId()
    {
        return array(
            array('fixture_full'),
            array('fixture_home'),
            array('fixture_directory')
        );
    }
}
