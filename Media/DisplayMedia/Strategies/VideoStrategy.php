<?php

namespace OpenOrchestra\Media\DisplayMedia\Strategies;

use OpenOrchestra\Media\Model\MediaInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class VideoStrategy
 */
class VideoStrategy extends AbstractStrategy
{
    const MIME_TYPE_FRAGMENT_VIDEO = 'video';

    protected $translator;

    /**
     * @param RequestStack $requestStack
     * @param string       $mediaDomain
     */
    public function __construct(RequestStack $requestStack, $mediaDomain = "", TranslatorInterface $translator)
    {
        parent::__construct($requestStack, $mediaDomain);
        $this->translator = $translator;
    }

    /**
     * @param MediaInterface $media
     *
     * @return bool
     */
    public function support(MediaInterface $media)
    {
        return strpos($media->getMimeType(), self::MIME_TYPE_FRAGMENT_VIDEO) === 0;
    }

    /**
     * @param MediaInterface $media
     * @param string         $format
     *
     * @return String
     */
    public function displayMedia(MediaInterface $media, $format = '')
    {
        return '<video width="320" height="240" controls>'
            . '<source src="' . $this->getFileUrl($media->getFilesystemName()) . '" type="' . $media->getMimeType() . '">'
            . $this->translator->trans('open_orchestra_media.strategy.video.tag_not_supported')
            . '</video>';
    }

    /**
     * @param MediaInterface $media
     * @param string         $format
     *
     * @return string
     */
    public function getMediaFormatUrl(MediaInterface $media, $format)
    {
        return $this->displayPreview($media);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'video';
    }
}
