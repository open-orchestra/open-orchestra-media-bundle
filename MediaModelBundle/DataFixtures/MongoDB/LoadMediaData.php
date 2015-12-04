<?php

namespace OpenOrchestra\MediaModelBundle\DataFixtures\MongoDB;

use Symfony\Component\HttpFoundation\File\UploadedFile;
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
class LoadMediaData
    extends AbstractFixture
    implements ContainerAwareInterface, OrderedFixtureInterface, OrchestraFunctionalFixturesInterface
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
        $logoOrchestra = $this->generateMedia(
            'logo-orchestra.png',
            'mediaFolder-rootImages',
            'logo Open-Orchestra',
            array('keyword-lorem'),
            array(
                'en' => array('alt' => 'logo', 'title' => 'logo image'),
                'fr' => array('alt' => 'thème', 'title' => 'thème./ image')
            )
        );
        $this->addReference('logo-orchestra', $logoOrchestra);

        for ($i = 1; $i < 5; $i++) {
            $this->generateMedia(
                '0' . $i . '.jpg',
                'mediaFolder-rootImages',
                'Image 0' . $i,
                array('keyword-lorem', 'keyword-dolor'),
                array(
                    'en' => array('alt' => 'image 0' . $i, 'title' => 'image 0' . $i),
                    'fr' => array('alt' => 'image 0' . $i, 'title' => 'image 0' . $i)
                )
            );
        }

        // Launch manually the method as there is no KernelEvents::TERMINATE fired in fixture mode
        $this->container->get('open_orchestra_media_admin.subscriber.create_media')->generateAlternatives();
    }

    /**
     * Generate a media
     * 
     * @param string $fileName
     * @param string $folderReference
     * @param string $name
     * @param array $keywordReferencesArray
     * @param array $languagesArray
     */
    protected function generateMedia(
        $fileName,
        $folderReference,
        $name,
        array $keywordReferencesArray,
        array $languagesArray
    ) {
        $folderId = $this->getReference($folderReference)->getId();
        $filePath = './vendor/open-orchestra/open-orchestra-media-bundle/MediaModelBundle/DataFixtures/Images/'
            . $fileName;
        $tmpFilePath = $this->container->getParameter('open_orchestra_media_admin.tmp_dir')
            . DIRECTORY_SEPARATOR . $fileName;

        copy($filePath, $tmpFilePath);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $tmpFilePath);
        finfo_close($finfo);

        $uploadedFile = new UploadedFile($tmpFilePath, $fileName, $mimeType);

        $saveMediaManager = $this->container->get('open_orchestra_media_admin.manager.save_media');
        $media = $saveMediaManager->createMediaFromUploadedFile($uploadedFile, $fileName, $folderId);

        $media->setName($name);
        foreach ($keywordReferencesArray as $keywordReference) {
            $media->addKeyword(EmbedKeyword::createFromKeyword($this->getReference($keywordReference)));
        }
        foreach ($languagesArray as $language => $labels) {
            $media->addAlt($this->generatedValue($language, $labels['alt']));
            $media->addTitle($this->generatedValue($language, $labels['title']));
        }

        return $media;
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
