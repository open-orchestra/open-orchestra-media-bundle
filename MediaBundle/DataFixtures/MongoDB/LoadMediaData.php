<?php

namespace OpenOrchestra\MediaBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\MediaBundle\Document\Media;
use OpenOrchestra\ModelBundle\Document\EmbedKeyword;
use OpenOrchestra\ModelBundle\Document\TranslatedValue;

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
        $rootImage->addAlt($this->generatedValue('en', 'logo'));
        $rootImage->addAlt($this->generatedValue('fr', 'thème'));
        $rootImage->addTitle($this->generatedValue('en', 'logo image'));
        $rootImage->addTitle($this->generatedValue('fr', 'thème./ image'));
        $manager->persist($rootImage);

        $firstImage = new Media();
        $firstImage->setName('No image logo');
        $firstImage->setFilesystemName('no_image_available.jpg');
        $firstImage->setThumbnail('no_image_available.jpg');
        $firstImage->setMimeType('image/jpg');
        $firstImage->setMediaFolder($this->getReference('mediaFolder-firstImages'));
        $firstImage->addKeyword(EmbedKeyword::createFromKeyword($this->getReference('keyword-lorem')));
        $firstImage->addKeyword(EmbedKeyword::createFromKeyword($this->getReference('keyword-dolor')));
        $firstImage->addAlt($this->generatedValue('en', 'firstImage'));
        $firstImage->addAlt($this->generatedValue('fr', 'premièreImage'));
        $firstImage->addTitle($this->generatedValue('en', 'firstImage'));
        $firstImage->addTitle($this->generatedValue('fr', 'premièreImage'));
        $manager->persist($firstImage);

        $secondImage = new Media();
        $secondImage->setName('Second image');
        $secondImage->setMediaFolder($this->getReference('mediaFolder-secondImages'));
        $secondImage->addKeyword(EmbedKeyword::createFromKeyword($this->getReference('keyword-dolor')));
        $secondImage->addAlt($this->generatedValue('en', 'secondImage'));
        $secondImage->addAlt($this->generatedValue('fr', 'secondImage'));
        $secondImage->addTitle($this->generatedValue('en', 'secondImage'));
        $secondImage->addTitle($this->generatedValue('fr', 'secondImage'));
        $manager->persist($secondImage);

        $manager->flush();
    }

    /**
     * @param string $language
     * @param string $value
     *
     * @return TranslatedValue
     */
    public function generatedValue($language, $value)
    {
        $label = new TranslatedValue();
        $label->setLanguage($language);
        $label->setValue($value);

        return $label;
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
