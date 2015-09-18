<?php

namespace OpenOrchestra\MediaModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OpenOrchestra\Media\Model\MediaInterface;
use OpenOrchestra\MediaModelBundle\Document\Media;
use OpenOrchestra\ModelBundle\Document\EmbedKeyword;
use OpenOrchestra\ModelBundle\Document\TranslatedValue;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use OpenOrchestra\ModelInterface\DataFixtures\OrchestraFunctionalFixturesInterface;

/**
 * Class LoadMediaData
 */
class LoadMediaData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface, OrchestraFunctionalFixturesInterface
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
        $logoOrchestra = $this->generateImage(
            'logo-orchestra.png',
            'logo Open-Orchestra',
            'image/png',
            'mediaFolder-rootImages',
            array('keyword-lorem'),
            array(
                'en' => array('alt' => 'logo', 'title' => 'logo image'),
                'fr' => array('alt' => 'thème', 'title' => 'thème./ image')
            )
        );
        $manager->persist($logoOrchestra);
        $this->addReference('logo-orchestra', $logoOrchestra);

        for ($i = 1; $i < 5; $i++) {
            $image0{$i} = $this->generateImage(
                '0' . $i . '.jpg',
                'Image 0' . $i,
                'image/jpg',
                'mediaFolder-rootImages',
                array(),
                array(
                    'en' => array('alt' => 'image 0' . $i, 'title' => 'image 0' . $i),
                    'fr' => array('alt' => 'image 0' . $i, 'title' => 'image 0' . $i)
                )
            );
            $manager->persist($image0{$i});
        }

        $manager->flush();
    }

    /**
     * Generate a Media (image format)
     * 
     * @param string $filename
     * @param string $name
     * @param string $mimeType
     * @param string $folderRefence
     * @param string $keywordReferencesArray
     * @param string $languagesArray
     * 
     * @return Media
     */
    protected function generateImage($filename, $name, $mimeType, $folderRefence, $keywordReferencesArray, $languagesArray) {
        $image = new Media();
        $image->setName($name);
        $image->setFilesystemName($filename);
        $image->setThumbnail($filename);
        $image->setMimeType($mimeType);
        $image->setMediaFolder($this->getReference($folderRefence));
        foreach ($keywordReferencesArray as $keywordReference) {
            $image->addKeyword(EmbedKeyword::createFromKeyword($this->getReference($keywordReference)));
        }
        foreach ($languagesArray as $language => $labels) {
            $image->addAlt($this->generatedValue($language, $labels['alt']));
            $image->addTitle($this->generatedValue($language, $labels['title']));
        }
        $this->copyFile($image);

        return $image;
    }

    /**
     * Copy the file physically and generate the thumbnails
     * 
     * @param MediaInterface $media
     */
    protected function copyFile(MediaInterface $media)
    {
        $file = './vendor/open-orchestra/open-orchestra-media-bundle/OpenOrchestra/MediaModelBundle/DataFixtures/Images/' . $media->getFilesystemName();
        $uploadedMediaManager = $this->container->get('open_orchestra_media.manager.uploaded_media');
        $imageResizerManager = $this->container->get('open_orchestra_media.manager.image_resizer');

        $uploadedMediaManager->uploadContent($media->getFilesystemName(), fopen($file, 'r'));

        copy($file, $this->container->getParameter('open_orchestra_media.tmp_dir') . '/'. $media->getFilesystemName());

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
        return 51;
    }
}
