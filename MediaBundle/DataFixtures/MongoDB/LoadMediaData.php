<?php

namespace OpenOrchestra\MediaBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\MediaBundle\Document\Media;
use OpenOrchestra\ModelBundle\Document\EmbedKeyword;

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
        $rootImage->setName('logo Phporchestra');
        $rootImage->setFilesystemName('themePresentation-logoOrchestra.png');
        $rootImage->setThumbnail('themePresentation-logoOrchestra.png');
        $rootImage->setMimeType('image/png');
        $rootImage->setMediaFolder($this->getReference('mediaFolder-rootImages'));
        $rootImage->addKeyword(EmbedKeyword::createFromKeyword($this->getReference('keyword-lorem')));
        $manager->persist($rootImage);

        $firstImage = new Media();
        $firstImage->setName('No image logo');
        $firstImage->setFilesystemName('no_image_available.jpg');
        $firstImage->setThumbnail('no_image_available.jpg');
        $firstImage->setMimeType('image/jpg');
        $firstImage->setMediaFolder($this->getReference('mediaFolder-firstImages'));
        $firstImage->addKeyword(EmbedKeyword::createFromKeyword($this->getReference('keyword-lorem')));
        $firstImage->addKeyword(EmbedKeyword::createFromKeyword($this->getReference('keyword-dolor')));
        $manager->persist($firstImage);

        $secondImage = new Media();
        $secondImage->setName('Second image');
        $secondImage->setMediaFolder($this->getReference('mediaFolder-secondImages'));
        $secondImage->addKeyword(EmbedKeyword::createFromKeyword($this->getReference('keyword-dolor')));
        $manager->persist($secondImage);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 410;
    }
}
