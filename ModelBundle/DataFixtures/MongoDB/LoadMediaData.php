<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Media;

/**
 * Class LoadMediaData
 */
class LoadMediaData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $rootImage = new Media();
        $rootImage->setName('Root image');
        $rootImage->setFolder($this->getReference('folder-rootImages'));
        $manager->persist($rootImage);

        $firstImage = new Media();
        $firstImage->setName('First image');
        $firstImage->setFolder($this->getReference('folder-firstImages'));
        $manager->persist($firstImage);

        $secondImage = new Media();
        $secondImage->setName('Second image');
        $secondImage->setFolder($this->getReference('folder-secondImages'));
        $manager->persist($secondImage);

        $firstFile = new Media();
        $firstFile->setName('First file');
        $firstFile->setFolder($this->getReference('folder-firstFiles'));
        $manager->persist($firstFile);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 55;
    }
}
