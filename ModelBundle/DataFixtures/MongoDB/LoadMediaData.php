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
    public function load(ObjectManager $manager)
    {
        $rootImage = new Media();
        $rootImage->setName('Root image');
        $rootImage->setMediaFolder($this->getReference('mediaFolder-rootImages'));
        $manager->persist($rootImage);

        $firstImage = new Media();
        $firstImage->setName('First image');
        $firstImage->setMediaFolder($this->getReference('mediaFolder-firstImages'));
        $manager->persist($firstImage);

        $secondImage = new Media();
        $secondImage->setName('Second image');
        $secondImage->setMediaFolder($this->getReference('mediaFolder-secondImages'));
        $manager->persist($secondImage);

        $firstFile = new Media();
        $firstFile->setName('First file');
        $firstFile->setMediaFolder($this->getReference('mediaFolder-firstFiles'));
        $manager->persist($firstFile);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 55;
    }
}
