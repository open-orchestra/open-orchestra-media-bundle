<?php

namespace PHPOrchestra\ModelBundle\Test\Validator\Constraints;

use Doctrine\Common\Collections\ArrayCollection;
use Phake;
use PHPOrchestra\ModelBundle\Validator\Constraints\PreventPublishedDocumentSave;
use PHPOrchestra\ModelBundle\Validator\Constraints\PreventPublishedDocumentSaveValidator;

/**
 * Class PreventPublishedDocumentSaveValidatorTest
 */
class PreventPublishedDocumentSaveValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PreventPublishedDocumentSaveValidator
     */
    protected $validator;

    protected $message = 'message';
    protected $translator;
    protected $constraint;
    protected $context;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->translator = Phake::mock('Symfony\Component\Translation\Translator');
        Phake::when($this->translator)->trans(Phake::anyParameters())->thenReturn($this->message);
        $this->context = Phake::mock('Symfony\Component\Validator\Context\ExecutionContext');
        $this->constraint = new PreventPublishedDocumentSave();

        $this->validator = new PreventPublishedDocumentSaveValidator($this->translator);
        $this->validator->initialize($this->context);
    }

    /**
     * Test validate
     *
     * @param Document $document
     * @param int      $numberOfViolation
     *
     * @dataProvider provideDocument
     */
    public function testValidate($document, $numberOfViolation)
    {
        $this->validator->validate($document, $this->constraint);
        Phake::verify($this->translator, Phake::times($numberOfViolation))->trans($this->constraint->message);
        Phake::verify($this->context, Phake::times($numberOfViolation))->addViolation($this->message);
    }

    /**
     * @return array
     */
    public function provideDocument()
    {

        $status0 = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusInterface');
        $statusableInterface0 = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusableInterface');
        Phake::when($status0)->isPublished()->thenReturn(true);
        Phake::when($statusableInterface0)->getStatus()->thenReturn($status0);

        $status1 = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusInterface');
        $statusableInterface1 = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusableInterface');
        Phake::when($status1)->isPublished()->thenReturn(false);
        Phake::when($statusableInterface1)->getStatus()->thenReturn($status1);

        $statusableInterface2 = Phake::mock('PHPOrchestra\ModelBundle\Model\StatusableInterface');
        Phake::when($statusableInterface2)->getStatus()->thenReturn(null);

        $notStatusableInterface = Phake::mock('\stdClass');

        return array(
            array($statusableInterface0, 1),
            array($statusableInterface1, 0),
            array($statusableInterface2, 0),
            array($notStatusableInterface, 0),
        );
    }
}
