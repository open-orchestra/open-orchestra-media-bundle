<?php

namespace OpenOrchestra\MediaModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\MediaModelBundle\Document\Media;
use OpenOrchestra\ModelBundle\Document\EmbedKeyword;
use OpenOrchestra\ModelBundle\Document\TranslatedValue;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadMediaData
 */
class LoadMediaData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $filename = 'logo-orchestra.png';
        $rootImage = new Media();
        $rootImage->setName('logo Open-Orchestra');
        $rootImage->setFilesystemName($filename);
        $rootImage->setThumbnail($filename);
        $rootImage->setMimeType('image/png');
        $rootImage->setMediaFolder($this->getReference('mediaFolder-rootImages'));
        $rootImage->addKeyword(EmbedKeyword::createFromKeyword($this->getReference('keyword-lorem')));
        $rootImage->addAlt($this->generatedValue('en', 'logo'));
        $rootImage->addAlt($this->generatedValue('fr', 'thème'));
        $rootImage->addTitle($this->generatedValue('en', 'logo image'));
        $rootImage->addTitle($this->generatedValue('fr', 'thème./ image'));
        $this->copyFile($rootImage);
        $manager->persist($rootImage);

        $filename = 'no_image_available.jpg';
        $firstImage = new Media();
        $firstImage->setName('No image logo');
        $firstImage->setFilesystemName($filename);
        $firstImage->setThumbnail($filename);
        $firstImage->setMimeType('image/jpg');
        $firstImage->setMediaFolder($this->getReference('mediaFolder-firstImages'));
        $firstImage->addKeyword(EmbedKeyword::createFromKeyword($this->getReference('keyword-lorem')));
        $firstImage->addKeyword(EmbedKeyword::createFromKeyword($this->getReference('keyword-dolor')));
        $firstImage->addAlt($this->generatedValue('en', 'firstImage'));
        $firstImage->addAlt($this->generatedValue('fr', 'premièreImage'));
        $firstImage->addTitle($this->generatedValue('en', 'firstImage'));
        $firstImage->addTitle($this->generatedValue('fr', 'premièreImage'));
        $this->copyFile($firstImage);
        $manager->persist($firstImage);

        $manager->flush();
    }

    /**
     * Copy the file physically and generate the thumbnails
     * 
     * @param string $filename
     */
    protected function copyFile(Media $media)
    {
        $file = './vendor/open-orchestra/open-orchestra-media-bundle/OpenOrchestra/MediaModelBundle/DataFixtures/Images/' . $media->getFilesystemName();
        $gaufretteManager = $this->container->get('open_orchestra_media.manager.gaufrette');
        $imageResizerManager = $this->container->get('open_orchestra_media.manager.image_resizer');

        $gaufretteManager->uploadContent(
            $media->getFilesystemName(),
            fopen($file, 'r')
        );

        copy(
            $file,
            $this->container->getParameter('open_orchestra_media.tmp_dir') . '/'. $media->getFilesystemName()
        );
        $imageResizerManager->generateAllThumbnails($media);;
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
