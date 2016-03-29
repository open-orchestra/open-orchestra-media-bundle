<?php

namespace OpenOrchestra\MediaModelBundle\Tests\Document;

use OpenOrchestra\BaseBundle\Tests\AbstractTest\AbstractBaseTestCase;
use Phake;
use OpenOrchestra\MediaModelBundle\Document\MediaFolder;

/**
 * Class FolderTest
 */
class FolderTest extends AbstractBaseTestCase
{
    protected $mediaFolder;
    protected $folder1;
    protected $folder2;
    protected $folder3;
    protected $sites1;
    protected $sites2;

    /**
     * Set Up the test
     */
    public function setUp()
    {
        $this->folder1 = Phake::mock('OpenOrchestra\Media\Model\FolderInterface');
        $this->folder2 = Phake::mock('OpenOrchestra\Media\Model\FolderInterface');
        $this->folder3 = Phake::mock('OpenOrchestra\Media\Model\FolderInterface');

        $this->sites1 = array(
            array('siteId' => 'site1'),
            array('siteId' => 'site2'),
        );
        $this->sites2 = array(
            array('siteId' => 'site1'),
        );

        $this->mediaFolder = new MediaFolder();
        $this->mediaFolder->addSubFolder($this->folder1);
        $this->mediaFolder->addSubFolder($this->folder2);
        $this->mediaFolder->addSubFolder($this->folder3);
    }

    /**
     * @return array
     */
    public function generateSiteId()
    {
        return array(
            array('site1', 3),
            array('site2', 2)
        );
    }
}
