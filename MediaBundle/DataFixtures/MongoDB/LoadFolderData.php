<?php

namespace OpenOrchestra\MediaBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\MediaBundle\Document\MediaFolder;

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
        $rootImages->addSite(array('siteId' => '1'));
        $rootImages->addSite(array('siteId' => '2'));
        $rootImages->addSite(array('siteId' => '3'));
        $manager->persist($rootImages);
        $this->addReference('mediaFolder-rootImages', $rootImages);

        $firstImages = new MediaFolder();
        $firstImages->setName('First images folder');
        $firstImages->setParent($rootImages);
        $firstImages->addSite(array('siteId' => '1'));
        $firstImages->addSite(array('siteId' => '2'));
        $manager->persist($firstImages);
        $this->addReference('mediaFolder-firstImages', $firstImages);

        $secondImages = new MediaFolder();
        $secondImages->setName('Second images folder');
        $secondImages->setParent($rootImages);
        $secondImages->addSite(array('siteId' => '1'));
        $manager->persist($secondImages);
        $this->addReference('mediaFolder-secondImages', $secondImages);

        $rootFiles = new MediaFolder();
        $rootFiles->setName('Files folder');
        $rootFiles->addSite(array('siteId' => '1'));
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
