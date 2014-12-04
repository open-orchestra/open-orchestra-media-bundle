<?php

namespace PHPOrchestra\MediaBundle\Test\DisplayMedia;

use PHPOrchestra\Media\DisplayMedia\DisplayMediaManager;

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

    /**
     * set up test
     */
    public function setUp()
    {
        $this->manager = new DisplayMediaManager($this->mediathequeUrl);
    }
}
