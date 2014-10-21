<?php

namespace PHPOrchestra\ModelBundle\Test\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Phake;
use PHPOrchestra\ModelBundle\Document\MediaFolder;
use PHPOrchestra\ModelBundle\Document\Site;

/**
 * Class FolderTest
 */
class FolderTest extends \PHPUnit_Framework_TestCase
{
    protected $mediaFolder;
    protected $folder1;
    protected $folder2;

    /**
     * Set Up the test
     */
    public function setUp()
    {
        $this->folder1 = Phake::mock('PHPOrchestra\ModelBundle\Model\FolderInterface');
        $this->folder2 = Phake::mock('PHPOrchestra\ModelBundle\Model\FolderInterface');

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
        Phake::when($this->folder1)->getSites()->thenReturn($this->generateSite1());
        Phake::when($this->folder2)->getSites()->thenReturn($this->generateSite2());

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
    /**
     * @return ArrayCollection
     */
    public function generateSite1()
    {
        $sites = new ArrayCollection();
        $site1 = new Site();
        $site1->setSiteId('site1');
        $sites->add($site1);

        $site2 = new Site();
        $site2->setSiteId('site2');
        $sites->add($site2);

        return $sites;
    }

    /**
     * @return ArrayCollection
     */
    public function generateSite2()
    {
        $sites = new ArrayCollection();

        $site1 = new Site();
        $site1->setSiteId('site1');
        $sites->add($site1);

        return $sites;
    }
}
