<?php

namespace PHPOrchestra\MediaBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\MediaBundle\Document\MediaFolder;

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
        $rootImages->addSite($this->getReference('site1'));
        $rootImages->addSite($this->getReference('site2'));
        $rootImages->addSite($this->getReference('site3'));
        $rootImages->addSite($this->getReference('site4'));
        $manager->persist($rootImages);
        $this->addReference('mediaFolder-rootImages', $rootImages);

        $firstImages = new MediaFolder();
        $firstImages->setName('First images folder');
        $firstImages->setParent($rootImages);
        $firstImages->addSite($this->getReference('site1'));
        $firstImages->addSite($this->getReference('site2'));
        $manager->persist($firstImages);
        $this->addReference('mediaFolder-firstImages', $firstImages);

        $secondImages = new MediaFolder();
        $secondImages->setName('Second images folder');
        $secondImages->setParent($rootImages);
        $secondImages->addSite($this->getReference('site1'));
        $manager->persist($secondImages);
        $this->addReference('mediaFolder-secondImages', $secondImages);

        $rootFiles = new MediaFolder();
        $rootFiles->setName('Files folder');
        $rootFiles->addSite($this->getReference('site1'));
        $rootFiles->addSite($this->getReference('site2'));
        $rootFiles->addSite($this->getReference('site3'));
        $rootFiles->addSite($this->getReference('site4'));
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
        return 90;
    }

}
