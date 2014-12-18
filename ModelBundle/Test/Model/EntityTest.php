<?php

namespace PHPOrchestra\ModelBundle\Test\Model;

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
        $fullClass = 'PHPOrchestra\ModelBundle\Document\\' . $class;
        $fullInterface = 'PHPOrchestra\ModelInterface\Model\\' . $interface;
        $entity = new $fullClass();

        $this->assertInstanceOf($fullInterface, $entity);
    }

    /**
     * @return array
     */
    public function providateClassInterfaceRelation()
    {
        return array(
            array('Node',             'NodeInterface'),
            array('Node',             'AreaContainerInterface'),
            array('Area',             'AreaContainerInterface'),
            array('Template',         'AreaContainerInterface'),
            array('Node',             'BlockContainerInterface'),
            array('Template',         'BlockContainerInterface'),
            array('Node',             'StatusableInterface'),
            array('Content',          'StatusableInterface'),
            array('ContentType',      'StatusableInterface'),
            array('Template',         'StatusableInterface'),
            array('ContentType',      'TranslatedValueContainerInterface'),
            array('FieldType',        'TranslatedValueContainerInterface'),
            array('Area',             'AreaInterface'),
            array('Block',            'BlockInterface'),
            array('ContentAttribute', 'ContentAttributeInterface'),
            array('Content',          'ContentInterface'),
            array('ContentType',      'ContentTypeInterface'),
            array('ContentType',      'FieldTypeContainerInterface'),
            array('FieldType',        'FieldTypeInterface'),
            array('FieldIndex',       'FieldIndexInterface'),
            array('FieldOption',      'FieldOptionInterface'),
            array('ListIndex',        'ListIndexInterface'),
            array('Site',             'SiteInterface'),
            array('Template',         'TemplateInterface'),
            array('TranslatedValue',  'TranslatedValueInterface'),
            array('Node',             'BlameableInterface'),
            array('Content',          'BlameableInterface'),
            array('ContentType',      'BlameableInterface'),
            array('Node',             'TimestampableInterface'),
            array('Content',          'TimestampableInterface'),
            array('ContentType',      'TimestampableInterface'),
            array('Theme',            'ThemeInterface'),
            array('Area',             'HtmlClassContainerInterface'),
            array('Keyword',          'KeywordInterface'),
            array('Content',          'KeywordableInterface'),
        );
    }
}
