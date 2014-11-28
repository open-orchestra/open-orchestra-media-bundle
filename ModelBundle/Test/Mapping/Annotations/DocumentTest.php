<?php
namespace PHPOrchestra\ModelBundle\Test\Mapping\Annotations;

use Phake;
use PHPOrchestra\ModelBundle\Mapping\Annotations\Document;
use PHPOrchestra\ModelBundle\Model\NodeInterface;
/**
 * Class DocumentTest
 */
class DocumentTest extends \PHPUnit_Framework_TestCase
{

    protected $node;

    /**
     * setUp
     */
    public function setUp()
    {
        $this->node = Phake::mock('PHPOrchestra\ModelBundle\Model\NodeInterface');
    }

    /**
     * @param array         $parameters
     * @param string        $exception
     * @param string        $expectedResult
     *
     * @dataProvider provideSource
     */
    public function testGetSource($parameters, $exception, $expectedResult)
    {
        if($exception !== null){
            $this->setExpectedException($exception);
        }
        $document = new Document($parameters);
        try {
            $source = $document->getSource($this->node);
        } catch (Exception $e) {
            $this->assertInstanceOf($exception, $e);
        }
        if($exception === null){
            $this->assertSame($source, $expectedResult);
        }
    }

    /**
     * @param array         $parameters
     * @param string        $exception
     * @param string        $expectedResult
     *
     * @dataProvider provideGetGenerated
     */
    public function testGetGenerated($parameters, $exception, $expectedResult)
    {
        if($exception !== null){
            $this->setExpectedException($exception);
        }
        $document = new Document($parameters);
        $generate = $document->getGenerated($this->node);
        if($exception){
            $this->setExpectedException($exception);
        }
        else{
            $this->assertSame($generate, $expectedResult);
        }
    }

    /**
     * @param array         $parameters
     * @param string        $exception
     * @param string        $expectedResult
     *
     * @dataProvider provideSetGenerated
     */
    public function testSetGenerated($parameters, $exception, $expectedResult)
    {
        if($exception !== null){
            $this->setExpectedException($exception);
        }
        $document = new Document($parameters);
        $generate = $document->setGenerated($this->node);
        if($exception){
            $this->setExpectedException($exception);
        }
        else{
            $this->assertSame($generate, $expectedResult);
        }
    }

    /**
     * @return array
     */
    public function provideSource()
    {
        $parameters0 = array('sourceField' => 'name');

        $parameters1 = array();

        $parameters2 = array('sourceField' => 'fakeproperty');

        return array(
            array($parameters0, null, 'getName'),
            array($parameters1, 'PHPOrchestra\ModelBundle\Exceptions\PropertyNotFoundException', null),
            array($parameters2, 'PHPOrchestra\ModelBundle\Exceptions\MethodNotFoundException', null),
        );
    }

    /**
     * @return array
     */
    public function provideGetGenerated()
    {
        $parameters0 = array('generatedField' => 'nodeId');

        $parameters1 = array();

        $parameters2 = array('generatedField' => 'fakeproperty');

        return array(
            array($parameters0, null, 'getNodeId'),
            array($parameters1, 'PHPOrchestra\ModelBundle\Exceptions\PropertyNotFoundException', null),
            array($parameters2, 'PHPOrchestra\ModelBundle\Exceptions\MethodNotFoundException', null),
        );
    }

    /**
     * @return array
     */
    public function provideSetGenerated()
    {
        $parameters0 = array('generatedField' => 'nodeId');

        $parameters1 = array();

        $parameters2 = array('generatedField' => 'fakeproperty');

        return array(
            array($parameters0, null, 'setNodeId'),
            array($parameters1, 'PHPOrchestra\ModelBundle\Exceptions\PropertyNotFoundException', null),
            array($parameters2, 'PHPOrchestra\ModelBundle\Exceptions\MethodNotFoundException', null),
        );
    }
}
