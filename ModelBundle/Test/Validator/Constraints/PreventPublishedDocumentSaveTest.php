<?php

namespace PHPOrchestra\ModelBundle\Test\Validator\Constraints;

use Phake;
use PHPOrchestra\ModelBundle\Validator\Constraints\PreventPublishedDocumentSave;
use Symfony\Component\Validator\Constraint;

/**
 * Class PreventPublishedDocumentSaveTest
 */
class PreventPublishedDocumentSaveTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PreventPublishedDocumentSave
     */
    protected $constraint;

    /**
     * Set up the test
     */
    public function setUp()
    {
        $this->constraint = new PreventPublishedDocumentSave();
    }

    /**
     * Test instance
     */
    public function testInstance()
    {
        $this->assertInstanceOf('Symfony\Component\Validator\Constraint', $this->constraint);
    }

    /**
     * Test validateBy
     */
    public function testValidateBy()
    {
        $this->assertSame('prevent_published_document_save', $this->constraint->validatedBy());
    }

    /**
     * test target
     */
    public function testTarget()
    {
        $this->assertSame(Constraint::CLASS_CONSTRAINT, $this->constraint->getTargets());
    }

    /**
     * test message
     */
    public function testMessages()
    {
        $this->assertSame('php_orchestra_model.document.impossible_save', $this->constraint->message);
    }
}
