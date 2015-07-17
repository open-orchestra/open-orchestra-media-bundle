<?php

namespace OpenOrchestra\MediaModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\MediaModelBundle\Document\MediaFolder;

/**
 * Class LoadFolderData
 */
class LoadFolderData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $rootImages = new MediaFolder();
        $rootImages->setName('Images folder');
        $rootImages->addSite(array('siteId' => '2'));
        $rootImages->addSite(array('siteId' => '3'));
        $manager->persist($rootImages);
        $this->addReference('mediaFolder-rootImages', $rootImages);

        $firstImages = new MediaFolder();
        $firstImages->setName('First images folder');
        $firstImages->setParent($rootImages);
        $firstImages->addSite(array('siteId' => '2'));
        $manager->persist($firstImages);
        $this->addReference('mediaFolder-firstImages', $firstImages);

        $rootFiles = new MediaFolder();
        $rootFiles->setName('Files folder');
        $rootFiles->addSite(array('siteId' => '2'));
        $rootFiles->addSite(array('siteId' => '3'));
        $manager->persist($rootFiles);
        $this->addReference('mediaFolder-rootFiles', $rootFiles);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 400;
    }

}
