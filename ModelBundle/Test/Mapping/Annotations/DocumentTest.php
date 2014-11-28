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
     * @param array  $parameters
     * @param string $expectedResult
     *
     * @dataProvider provideSource
     */
    public function testGetSource($parameters, $expectedResult)
    {
        $this->makeTest('getSource', $parameters, $expectedResult);
    }

    /**
     * @param array  $parameters
     * @param string $exception
     *
     * @dataProvider provideExceptionSource
     */
    public function testExceptionGetSource($parameters, $exception)
    {
        $this->makeExceptionTest('getSource', $parameters, $exception);
    }

    /**
     * @param array  $parameters
     * @param string $expectedResult
     *
     * @dataProvider provideGetGenerated
     */
    public function testGetGenerated($parameters, $expectedResult)
    {
        $this->makeTest('getGenerated', $parameters, $expectedResult);
    }

    /**
     * @param array  $parameters
     * @param string $exception
     *
     * @dataProvider provideExceptionGetGenerated
     */
    public function testExceptionGetGenerated($parameters, $exception)
    {
        $this->makeExceptionTest('getGenerated', $parameters, $exception);
    }

    /**
     * @param array  $parameters
     * @param string $expectedResult
     *
     * @dataProvider provideSetGenerated
     */
    public function testSetGenerated($parameters, $expectedResult)
    {
        $this->makeTest('setGenerated', $parameters, $expectedResult);
    }

    /**
     * @param array  $parameters
     * @param string $exception
     *
     * @dataProvider provideExceptionSetGenerated
     */
    public function testExceptionSetGenerated($parameters, $exception)
    {
        $this->makeExceptionTest('setGenerated', $parameters, $exception);
    }

    /**
     * @param string $method
     * @param array  $parameters
     * @param string $expectedResult
     */
    public function makeTest($method, $parameters, $expectedResult)
    {
        $document = new Document($parameters);
        $source = $document->$method($this->node);
        $this->assertSame($source, $expectedResult);
    }

    /**
     * @param string $method
     * @param array  $parameters
     * @param string $exception
     */
    public function makeExceptionTest($method, $parameters, $exception)
    {
        $document = new Document($parameters);
        $this->setExpectedException($exception);
        try {
            $source = $document->$method($this->node);
        } catch (Exception $e) {
            $this->assertInstanceOf($exception, $e);
        }
    }

    /**
     * @return array
     */
    public function provideSource()
    {
        $parameters0 = array('sourceField' => 'name');

        return array(
            array($parameters0, 'getName'),
        );
    }

    /**
     * @return array
     */
    public function provideExceptionSource()
    {
        $parameters0 = array();

        $parameters1 = array('sourceField' => 'fakeproperty');

        return array(
            array($parameters0, 'PHPOrchestra\ModelBundle\Exceptions\PropertyNotFoundException'),
            array($parameters1, 'PHPOrchestra\ModelBundle\Exceptions\MethodNotFoundException'),
        );
    }

    /**
     * @return array
     */
    public function provideGetGenerated()
    {
        $parameters0 = array('generatedField' => 'nodeId');

        return array(
            array($parameters0, 'getNodeId'),
        );
    }

    /**
     * @return array
     */
    public function provideExceptionGetGenerated()
    {
        $parameters0 = array();

        $parameters1 = array('generatedField' => 'fakeproperty');

        return array(
            array($parameters0, 'PHPOrchestra\ModelBundle\Exceptions\PropertyNotFoundException'),
            array($parameters1, 'PHPOrchestra\ModelBundle\Exceptions\MethodNotFoundException'),
        );
    }

    /**
     * @return array
     */
    public function provideSetGenerated()
    {
        $parameters0 = array('generatedField' => 'nodeId');

        return array(
            array($parameters0, 'setNodeId'),
        );
    }

    /**
     * @return array
     */
    public function provideExceptionSetGenerated()
    {
        $parameters0 = array();

        $parameters1 = array('generatedField' => 'fakeproperty');

        return array(
            array($parameters0, 'PHPOrchestra\ModelBundle\Exceptions\PropertyNotFoundException'),
            array($parameters1, 'PHPOrchestra\ModelBundle\Exceptions\MethodNotFoundException'),
        );
    }
}
