<?php

namespace PHPOrchestra\MediaBundle\Twig;

use PHPOrchestra\Media\DisplayMedia\DisplayMediaManager;
use PHPOrchestra\Media\Repository\MediaRepositoryInterface;

/**
 * Class DisplayMediaExtension
 */
class DisplayMediaExtension extends \Twig_Extension
{
    protected $displayMediaManager;
    protected $mediaRepository;

    /**
     * @param DisplayMediaManager      $displayMediaManager
     * @param MediaRepositoryInterface $mediaRepository
     */
    public function __construct(DisplayMediaManager $displayMediaManager, MediaRepositoryInterface $mediaRepository)
    {
        $this->displayMediaManager = $displayMediaManager;
        $this->mediaRepository = $mediaRepository;

    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('display_media', array($this, 'displayMedia'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('media_preview', array($this, 'mediaPreview')),
        );
    }

    /**
     * @param String $mediaId
     *
     * @return String
     */
    public function displayMedia($mediaId)
    {
        $media = $this->mediaRepository->find($mediaId);

        if ($media) {
            return $this->displayMediaManager->displayMedia($media);
        } else {
            return '';
        }
    }

    /**
     * @param String $mediaId
     *
     * @return String
     */
    public function mediaPreview($mediaId)
    {
        $media = $this->mediaRepository->find($mediaId);

        if ($media) {
            return $this->displayMediaManager->displayPreview($media);
        }
        return '';
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'media';
    }
}
