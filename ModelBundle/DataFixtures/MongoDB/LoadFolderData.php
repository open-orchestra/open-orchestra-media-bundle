<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Folder;

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
        $rootImages = new Folder();
        $rootImages->setName('Images');
        $manager->persist($rootImages);
        $this->addReference('folder-rootImages', $rootImages);

        $firstImages = new Folder();
        $firstImages->setName('First images');
        $firstImages->setParent($rootImages);
        $manager->persist($firstImages);
        $this->addReference('folder-firstImages', $firstImages);

        $secondImages = new Folder();
        $secondImages->setName('Second images');
        $secondImages->setParent($rootImages);
        $manager->persist($secondImages);
        $this->addReference('folder-secondImages', $secondImages);

        $rootFiles = new Folder();
        $rootFiles->setName('Files');
        $manager->persist($rootFiles);
        $this->addReference('folder-rootFiles', $rootFiles);

        $firstFiles = new Folder();
        $firstFiles->setName('First files');
        $firstFiles->setParent($rootFiles);
        $manager->persist($firstFiles);
        $this->addReference('folder-firstFiles', $firstFiles);

        $secondFiles = new Folder();
        $secondFiles->setName('Second files');
        $secondFiles->setParent($rootFiles);
        $manager->persist($secondFiles);
        $this->addReference('folder-secondFiles', $secondFiles);

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
