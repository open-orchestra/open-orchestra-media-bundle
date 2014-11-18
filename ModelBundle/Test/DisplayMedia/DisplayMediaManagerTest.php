<?php

namespace PHPOrchestra\ModelBundle\Test\DisplayMedia;

use PHPOrchestra\ModelBundle\DisplayMedia\DisplayMediaManager;

/**
 * Class DisplayMediaManagerTest
 */
class DisplayMediaManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DisplayMediaManager
     */
    protected $manager;

    protected $mediathequeUrl = 'url';
    protected $noImageAvailable = 'noImage';

    /**
     * set up test
     */
    public function setUp()
    {
        $this->manager = new DisplayMediaManager($this->mediathequeUrl, $this->noImageAvailable);
    }

    /**
     * Test no preview
     */
    public function testDisplayNoMediaPreview()
    {
        $this->assertSame($this->mediathequeUrl . '/' . $this->noImageAvailable, $this->manager->displayNoMediaPreview());
    }
}
