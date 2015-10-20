<?php

namespace OpenOrchestra\Media\DisplayMedia\Strategies;

use Symfony\Component\DependencyInjection\ContainerAware;
use OpenOrchestra\Media\DisplayMedia\DisplayMediaInterface;
use OpenOrchestra\Media\Model\MediaInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class AbstractStrategy
 */
abstract class AbstractStrategy extends ContainerAware implements DisplayMediaInterface
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
    public function displayMediaForWysiwyg(MediaInterface $media, $format = '')
    {
        return $this->render(
            'OpenOrchestraMediaBundle:BBcode/WysiwygDisplay:thumbnail.html.twig',
            array(
                'media_url' => $this->getFileUrl($media->getThumbnail()),
                'media_alt' => $media->getAlt($this->request->getLocale()),
                'media_id' => $media->getId()
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
