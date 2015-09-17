<?php

namespace OpenOrchestra\Media\DisplayMedia\Strategies;

use OpenOrchestra\Media\DisplayMedia\DisplayMediaInterface;
use OpenOrchestra\Media\Model\MediaInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class AbstractStrategy
 */
abstract class AbstractStrategy implements DisplayMediaInterface
{
    protected $router;
    protected $request;
    protected $mediaDomain;

    /**
     * @param RequestStack $requestStack
     * @param string       $mediaDomain
     */
    public function __construct(RequestStack $requestStack, $mediaDomain = "")
    {
        $this->request = $requestStack->getMasterRequest();
        $this->mediaDomain = $mediaDomain;
    }

    /**
     * Set the router
     * 
     * @param Router $router
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    /**
     * @param MediaInterface $media
     *
     * @return String
     */
    public function displayPreview(MediaInterface $media)
    {
        return $this->getFileUrl($media->getThumbnail());
    }

    /**
     * @param MediaInterface $media
     *
     *  @param MediaInterface $media
     *  @param string         $format
     *  
     * @return string
     */
    public function displayMediaForWysiwyg(MediaInterface $media, $format = '')
    {
        return '<img class="tinymce-media" src="' . $this->getFileUrl($media->getFilesystemName(), $format) . '" alt="'
            . $media->getAlt($this->request->getLocale()) . '" data-id="' . $media->getId() . '" data-format="' . $format . '" />';
    }

    /**
     * Return url to a file stored with gaufrette
     * 
     * @param string $filename
     * @param string $format
     *
     * @return String
     */
    protected function getFileUrl($filename, $format = '')
    {
        $key = $filename;
        if ($format != '' && MediaInterface::MEDIA_ORIGINAL != $format) {
            $key = $format . '-' . $filename;
        }

        return '//' . $this->mediaDomain
            . $this->router->generate('open_orchestra_media_get',
            array('key' => $key),
            UrlGeneratorInterface::ABSOLUTE_PATH
        );
    }
}
