<?php

namespace OpenOrchestra\MediaModelBundle\Tests\Model;

/**
 * Description of BaseNodeTest
 */
class EntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $class
     * @param string $interface
     *
     * @dataProvider providateClassInterfaceRelation
     */
    public function testInstance($class, $interface)
    {
        $fullClass = 'OpenOrchestra\MediaModelBundle\Document\\' . $class;
        $fullInterface = 'OpenOrchestra\Media\Model\\' . $interface;
        $entity = new $fullClass();

        $this->assertInstanceOf($fullInterface, $entity);
    }

    /**
     * @return array
     */
    public function providateClassInterfaceRelation()
    {
        return array(
            array('Media',            'MediaInterface'),
            array('MediaFolder',      'FolderInterface'),
            array('MediaFolder',      'MediaFolderInterface'),
        );
    }

    /**
     * @param string $class
     * @param string $interface
     *
     * @dataProvider providateClassInterfaceRelationOfModelInterface
     */
    public function testInstanceOfModelInterface($class, $interface)
    {
        $fullClass = 'OpenOrchestra\MediaModelBundle\Document\\' . $class;
        $fullInterface = 'OpenOrchestra\ModelInterface\Model\\' . $interface;
        $entity = new $fullClass();

        $this->assertInstanceOf($fullInterface, $entity);
    }

    /**
     * @return array
     */
    public function providateClassInterfaceRelationOfModelInterface()
    {
        return array(
            array('Media',            'BlameableInterface'),
            array('MediaFolder',      'BlameableInterface'),
            array('Media',            'TimestampableInterface'),
            array('MediaFolder',      'TimestampableInterface'),
            array('Media',            'KeywordableInterface'),
        );
    }
}
