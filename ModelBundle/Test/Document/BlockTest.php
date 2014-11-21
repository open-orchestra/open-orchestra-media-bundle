<?php

namespace PHPOrchestra\ModelBundle\Test\Document;

use PHPOrchestra\ModelBundle\Document\Block;

/**
 * Class BlockTest
 */
class BlockTest extends \PHPUnit_Framework_TestCase
{
    protected $block;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->block = new Block();
    }

    /**
     * @param string $areaId
     * @param string $nodeId
     * @param array  $expected
     *
     * @dataProvider provideAreaIdNodeIdArray
     */
    public function testRemoveAreaRef($areaId, $nodeId, $expected)
    {
        $this->block->addArea(array('nodeId' => 'what', 'areaId' => 'moduleArea'));
        $this->block->addArea(array('nodeId' => 'what', 'areaId' => 'testarea'));
        $this->block->addArea(array('nodeId' => 'start', 'areaId' => 'moduleArea'));
        $this->block->addArea(array('nodeId' => 'documentation', 'areaId' => 'testarea'));

        $this->block->removeAreaRef($areaId, $nodeId);

        $this->assertSame($expected, $this->block->getAreas());
    }

    /**
     * @return array
     */
    public function provideAreaIdNodeIdArray()
    {
        return array(
            array('moduleArea', 'what', array(
                1 => array('nodeId' => 'what', 'areaId' => 'testarea'),
                2 => array('nodeId' => 'start', 'areaId' => 'moduleArea'),
                3 => array('nodeId' => 'documentation', 'areaId' => 'testarea'),
            )),
            array('moduleArea', 'start', array(
                0 => array('nodeId' => 'what', 'areaId' => 'moduleArea'),
                1 => array('nodeId' => 'what', 'areaId' => 'testarea'),
                3 => array('nodeId' => 'documentation', 'areaId' => 'testarea'),
            )),
            array('testarea', 'documentation', array(
                0 => array('nodeId' => 'what', 'areaId' => 'moduleArea'),
                1 => array('nodeId' => 'what', 'areaId' => 'testarea'),
                2 => array('nodeId' => 'start', 'areaId' => 'moduleArea'),
            )),
            array('moduleArea', 'documentation', array(
                0 => array('nodeId' => 'what', 'areaId' => 'moduleArea'),
                1 => array('nodeId' => 'what', 'areaId' => 'testarea'),
                2 => array('nodeId' => 'start', 'areaId' => 'moduleArea'),
                3 => array('nodeId' => 'documentation', 'areaId' => 'testarea'),
            )),
        );
    }

    /**
     * @param string $areaId
     * @param string $nodeId
     * @param array  $expected
     *
     * @dataProvider provideAreaIdNodeIdArrayWithOneArea
     */
    public function testRemoveAreaRefWithOneArea($areaId, $nodeId, $expected)
    {
        $this->block->addArea(array('nodeId' => 'what', 'areaId' => 'moduleArea'));

        $this->block->removeAreaRef($areaId, $nodeId);

        $this->assertSame($expected, $this->block->getAreas());
    }

    /**
     * @return array
     */
    public function provideAreaIdNodeIdArrayWithOneArea()
    {
        return array(
            array('moduleArea', 'what', array()),
            array('testarea', 'what', array(
                0 => array('nodeId' => 'what', 'areaId' => 'moduleArea'),
            )),
        );
    }
}
