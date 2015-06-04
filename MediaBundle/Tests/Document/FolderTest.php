<?php

namespace OpenOrchestra\MediaBundle\Tests\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Phake;
use OpenOrchestra\MediaBundle\Document\MediaFolder;

/**
 * Class FolderTest
 */
class FolderTest extends \PHPUnit_Framework_TestCase
{
    protected $mediaFolder;
    protected $folder1;
    protected $folder2;
    protected $sites1;
    protected $sites2;

    /**
     * Set Up the test
     */
    public function setUp()
    {
        $this->folder1 = Phake::mock('OpenOrchestra\Media\Model\FolderInterface');
        $this->folder2 = Phake::mock('OpenOrchestra\Media\Model\FolderInterface');

        $this->sites1 = array('site1', 'site2');
        $this->sites2 = array('site1');

        $this->mediaFolder = new MediaFolder();
        $this->mediaFolder->addSubFolder($this->folder1);
        $this->mediaFolder->addSubFolder($this->folder2);
    }

    /**
     * Test getSubFoldersBySiteId
     *
     * @param string $siteId
     * @param int    $nbResult
     *
     * @dataProvider generateSiteId
     */
    public function testGetSubFoldersBySiteId($siteId, $nbResult)
    {
        Phake::when($this->folder1)->getSites()->thenReturn($this->sites1);
        Phake::when($this->folder2)->getSites()->thenReturn($this->sites2);

        $result = $this->mediaFolder->getSubFoldersBySiteId($siteId);

        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $result);
        $this->assertCount($nbResult, $result);
    }

    /**
     * @return array
     */
    public function generateSiteId()
    {
        return array(
            array('site1', 2),
            array('site2', 1)
        );
    }

}