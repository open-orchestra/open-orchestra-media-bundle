<?php
/**
 * Created by PhpStorm.
 * User: bfouche
 * Date: 28/07/14
 * Time: 18:05
 */

namespace PHPOrchestra\IndexationBundle\Test\SolrConverter\Strategies;

use Model\PHPOrchestraCMSBundle\Node;
use Phake;
use PHPOrchestra\IndexationBundle\SolrConverter\Strategies\ContentConverterStrategy;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class ContentConverterStrategyTest
 */
class ContentConverterStrategyTest extends \PHPUnit_Framework_TestCase
{

    protected $strategies;
    protected $strategy;
    protected $mandango;
    protected $router;
    protected $url;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->strategies = array('content');
        $this->url = 'http://phporchestra.dev/app_dev/fixture_full';

        $this->mandango = Phake::mock('PHPOrchestra\CMSBundle\Test\Mock\Mandango');
        $this->router = Phake::mock('PHPOrchestra\CMSBundle\Routing\PhpOrchestraUrlGenerator');
        Phake::when($this->router)->generate(Phake::anyParameters())->thenReturn($this->url);

        $this->strategy = new ContentConverterStrategy($this->router, $this->mandango);
    }

    /**
     * Assert that the strategy is supported
     */
    public function testSupport()
    {
        $content = Phake::mock('Model\PHPOrchestraCMSBundle\Content');
        $this->assertTrue($this->strategy->support($content));
    }

    /**
     * test the strategy with another object
     */
    public function testDoesNotSupport()
    {
        $fieldIndex = Phake::mock('Model\PHPOrchestraCMSBundle\FieldIndex');
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
        $content = Phake::mock('Model\PHPOrchestraCMSBundle\Content');
        $update = Phake::mock('Solarium\QueryType\Update\Query\Query');
        Phake::when($update)->createDocument()->thenReturn($document);

        $this->assertSame($document, $this->strategy->toSolrDocument($content, $fields, $update));

        Phake::verify($update)->createDocument();
        Phake::verify($content)->getContentId();
        Phake::verify($content)->getShortName();
        Phake::verify($content)->getVersion();
        Phake::verify($content)->getLanguage();
        Phake::verify($content)->getContentType();
        Phake::verify($content)->getStatus();
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
     * Test Get Content
     */
    public function testGetContent()
    {
        $fieldName = 'title';
        $value = 'Hello wolrd';
        $contentAttributes = Phake::mock('Model\PHPOrchestraCMSBundle\ContentAttribute');
        Phake::when($contentAttributes)->getName()->thenReturn($fieldName);
        Phake::when($contentAttributes)->getValue()->thenReturn($value);

        $content = Phake::mock('Model\PHPOrchestraCMSBundle\Content');
        Phake::when($content)->getAttributes()->thenReturn(array($contentAttributes, $contentAttributes));

        $result = $this->strategy->getContent($content, $fieldName, false);
        $this->assertSame($value, $result);

        Phake::verify($contentAttributes)->getName();
        Phake::verify($contentAttributes)->getValue();

    }

    /**
     * @param Node $nodes
     *
     * @dataProvider provideNodes
     */
    public function testGenerateUrl($nodes)
    {
        $type = 'news';
        $nodeId = 'fixture_full';
        $contentId = '3';
        $content = Phake::mock('Model\PHPOrchestraCMSBundle\Content');
        $nodeRepository = Phake::mock('Model\PHPOrchestraCMSBundle\NodeRepository');
        $block = Phake::mock('Model\PHPOrchestraCMSBundle\Block');

        Phake::when($this->mandango)->getRepository(Phake::anyParameters())->thenReturn($nodeRepository);
        Phake::when($nodeRepository)->getAllNodes()->thenReturn($nodes);
        Phake::when($content)->getContentType()->thenReturn($type);

        foreach ($nodes as $node) {
            Phake::when($node)->getBlocks()->thenReturn(array($block, $block));
            Phake::when($node)->getNodeId()->thenReturn($nodeId);
        }
        Phake::when($block)->getAttributes()->thenReturn(array('title' => 'test', 'contentType' => $type));
        Phake::when($content)->getContentId()->thenReturn($contentId);

        $this->assertSame($this->url, $this->strategy->generateUrl($content));

        Phake::verify($this->mandango)->getRepository('Model\PHPOrchestraCMSBundle\Node');
        Phake::verify($nodeRepository)->getAllNodes();
        Phake::verify($content)->getContentType();

        foreach ($nodes as $node) {
            Phake::verify($node, Phake::atLeast(1))->getBlocks();
            Phake::verify($block)->getAttributes();
            Phake::verify($node, Phake::atLeast(1))->getNodeId();
        }
        Phake::verify($content)->getContentId();
        Phake::verify($this->router)->generate($nodeId, array($contentId), UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @return array
     */
    public function provideNodes()
    {
        $node = Phake::mock('Model\PHPOrchestraCMSBundle\Node');

        return array(
            array(array($node)),
            array(array($node, $node))
        );
    }
}
