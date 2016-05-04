<?php

namespace OpenOrchestra\Media\DisplayMedia\Strategies;

use OpenOrchestra\Media\DisplayMedia\DisplayMediaInterface;
use OpenOrchestra\Media\Model\MediaInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class AbstractStrategy
 */
abstract class AbstractStrategy implements DisplayMediaInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected $router;
    protected $requestStack;
    protected $mediaDomain;

    /**
     * @param RequestStack $requestStack
     * @param string       $mediaDomain
     */
    public function __construct(RequestStack $requestStack, $mediaDomain = "")
    {
        $this->requestStack = $requestStack;
        $this->mediaDomain = $mediaDomain;
    }

    /**
     * Set the router
     *
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router)
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
    public function displayMediaForWysiwyg(MediaInterface $media, $format = '', $style = '')
    {
        $request = $this->requestStack->getMasterRequest();

        return $this->render(
            'OpenOrchestraMediaBundle:BBcode/WysiwygDisplay:thumbnail.html.twig',
            array(
                'media_url' => $this->getFileUrl($media->getThumbnail()),
                'media_alt' => $media->getAlt($request->getLocale()),
                'media_id' => $media->getId(),
                'style' => $style
            )
        );
    }

    /**
     * Render the $template with $params
     *
     * @param string $template
     * @param array  $params
     *
     * @return string
     */
    protected function render($template, $params)
    {
        return $this->container->get('templating')->render($template, $params);
    }

    /**
     * Return url to a file stored with the UploadedFileManager
     *
     * @param string storageKey
     *
     * @return string
     */
    protected function getFileUrl($storageKey)
    {
        return '//' . $this->mediaDomain
            . $this->router->generate('open_orchestra_media_get',
            array('key' => $storageKey),
            UrlGeneratorInterface::ABSOLUTE_PATH
        );
    }
}
