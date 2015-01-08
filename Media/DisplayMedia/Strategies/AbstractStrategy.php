<?php

namespace PHPOrchestra\Media\DisplayMedia\Strategies;

use PHPOrchestra\Media\DisplayMedia\DisplayMediaInterface;
use PHPOrchestra\Media\Model\MediaInterface;
use Symfony\Component\Routing\Router;

/**
 * Class AbstractStrategy
 */
abstract class AbstractStrategy implements DisplayMediaInterface
{
    protected $router;

    /**
     * @param Router $router
     */
    public function __construct(Router $router)
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
     * Return url to a file stored with gaufrette
     * 
     * @param string $filename
     *
     * @return String
     */
    protected function getFileUrl($filename)
    {
        return $this->router->generate(
            'php_orchestra_media_get',
            array('key' => $filename),
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }
}
