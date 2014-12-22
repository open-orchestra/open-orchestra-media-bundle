<?php

namespace PHPOrchestra\ModelBundle\Test\Form\Type;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Phake;
use PHPOrchestra\ModelBundle\Form\Type\OrchestraSiteType;

/**
 * Class OrchestraSiteTypeTest
 */
class OrchestraSiteTypeTest extends \PHPUnit_Framework_TestCase
{
    protected $form;
    protected $siteClass = 'SiteClass';

    /**
     * Set up the text
     */
    public function setUp()
    {
        $this->form = new OrchestraSiteType($this->siteClass);
    }

    /**
     * Test Name
     */
    public function testName()
    {
        $this->assertSame('orchestra_site', $this->form->getName());
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
            'class' => $this->siteClass,
            'property' => 'domain',
            'query_builder' => function (DocumentRepository $dr) {
                return $dr->createQueryBuilder('s')->field('deleted')->equals(false);
            },
        ));
    }
}
