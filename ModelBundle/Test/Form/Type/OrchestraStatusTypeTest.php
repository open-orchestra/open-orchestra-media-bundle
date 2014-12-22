<?php

namespace PHPOrchestra\ModelBundle\Test\Form\Type;

use Phake;
use PHPOrchestra\ModelBundle\Form\Type\OrchestraStatusType;

/**
 * Class OrchestraStatusTypeTest
 */
class OrchestraStatusTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OrchestraStatusType
     */
    protected $form;

    protected $builder;
    protected $transformer;
    protected $statusClass = 'statusClass';

    /**
     * Set up the text
     */
    public function setUp()
    {
        $this->builder = Phake::mock('Symfony\Component\Form\FormBuilder');
        $this->transformer = Phake::mock('PHPOrchestra\ModelBundle\Form\DataTransformer\EmbedStatusToStatusTransformer');

        $this->form = new OrchestraStatusType($this->transformer, $this->statusClass);
    }

    /**
     * Test Name
     */
    public function testName()
    {
        $this->assertSame('orchestra_status', $this->form->getName());
    }

    /**
     * Test Parent
     */
    public function testParent()
    {
        $this->assertSame('document', $this->form->getParent());
    }

    /**
     * Test the default options
     */
    public function testSetDefaultOptions()
    {
        $resolverMock = Phake::mock('Symfony\Component\OptionsResolver\OptionsResolverInterface');

        $this->form->setDefaultOptions($resolverMock);

        Phake::verify($resolverMock)->setDefaults(array(
            'class' => $this->statusClass,
            'property' => 'labels',
        ));
    }

    /**
     * Test model transformer
     */
    public function testBuildForm()
    {
        $this->form->buildForm($this->builder, array());

        Phake::verify($this->builder)->addModelTransformer($this->transformer);
    }
}
