<?php

namespace PHPOrchestra\ModelBundle\Test\EventListener;

use Phake;
use PHPOrchestra\ModelBundle\EventListener\GenerateTemplateIdListener;

/**
 * Class GenerateTemplateIdListenerTest
 */
class GenerateTemplateIdListenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GenerateTemplateIdListener
     */
    protected $listener;

    protected $event;
    protected $template;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->template = Phake::mock('PHPOrchestra\ModelBundle\Model\TemplateInterface');
        $this->event = Phake::mock('Doctrine\ODM\MongoDB\Event\LifecycleEventArgs');
        Phake::when($this->event)->getDocument()->thenReturn($this->template);

        $this->listener = new GenerateTemplateIdListener();
    }

    /**
     * test if the method is callable
     */
    public function testMethodPrePersistCallable()
    {
        $this->assertTrue(method_exists($this->listener, 'prePersist'));
    }

    /**
     * @param string $page
     * @param string $expectedTemplateId
     *
     * @dataProvider provideTemplateIntel
     */
    public function testPrePersist($page, $expectedTemplateId)
    {
        Phake::when($this->template)->getName()->thenReturn($page);

        $this->listener->prePersist($this->event);

        Phake::verify($this->template)->setTemplateId($expectedTemplateId);
    }

    /**
     * @return array
     */
    public function provideTemplateIntel()
    {
        return array(
            array('page', 'page'),
            array('new page', 'new_page'),
            array('new Page', 'new_page'),
        );
    }

    /**
     * Test with already set templateId
     */
    public function testPrePersistWithTemplateIdAlreadySet()
    {
        Phake::when($this->template)->getTemplateId()->thenReturn('something');

        $this->listener->prePersist($this->event);

        Phake::verify($this->template, Phake::never())->getName();
        Phake::verify($this->template, Phake::never())->setTemplateId(Phake::anyParameters());
    }
}
