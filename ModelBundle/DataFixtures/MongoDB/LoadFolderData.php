<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\MediaFolder;

/**
 * Class LoadFolderData
 */
class LoadFolderData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $rootImages = new MediaFolder();
        $rootImages->setName('Images');
        $manager->persist($rootImages);
        $this->addReference('mediaFolder-rootImages', $rootImages);

        $firstImages = new MediaFolder();
        $firstImages->setName('First images');
        $firstImages->setParent($rootImages);
        $manager->persist($firstImages);
        $this->addReference('mediaFolder-firstImages', $firstImages);

        $secondImages = new MediaFolder();
        $secondImages->setName('Second images');
        $secondImages->setParent($rootImages);
        $manager->persist($secondImages);
        $this->addReference('mediaFolder-secondImages', $secondImages);

        $rootFiles = new MediaFolder();
        $rootFiles->setName('Files');
        $manager->persist($rootFiles);
        $this->addReference('mediaFolder-rootFiles', $rootFiles);

        $firstFiles = new MediaFolder();
        $firstFiles->setName('First files');
        $firstFiles->setParent($rootFiles);
        $manager->persist($firstFiles);
        $this->addReference('mediaFolder-firstFiles', $firstFiles);

        $secondFiles = new MediaFolder();
        $secondFiles->setName('Second files');
        $secondFiles->setParent($rootFiles);
        $manager->persist($secondFiles);
        $this->addReference('mediaFolder-secondFiles', $secondFiles);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 35;
    }

}
