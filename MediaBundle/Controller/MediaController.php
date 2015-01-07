<?php

namespace PHPOrchestra\MediaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as Config;

/**
 * Class MediaController
 */
class MediaController extends Controller
{
    /**
     * Send a media stored via gaufrette
     *
     * @Config\Route("/{key}", name="php_orchestra_media_get")
     * @Config\Method({"GET"})
     *
     * @return Response
     */
    public function getAction($key)
    {
        $gaufretteManager = $this->get('php_orchestra_media.manager.gaufrette');

        $response = new Response();
        $response->setContent($gaufretteManager->getMediaContent($key));

        return $response;
    }
}
