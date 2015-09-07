<?php 

namespace OpenOrchestra\MediaBundle\BBcode;

use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use OpenOrchestra\BBcodeBundle\Definition\BBcodeDefinition;
use OpenOrchestra\BBcodeBundle\Node\BBcodeElementNodeInterface;
use JBBCode\ElementNode;
use OpenOrchestra\Media\Model\MediaInterface;
use Symfony\Component\Routing\RequestContextAwareInterface;

/**
 * Class MediaCodeDefinition
 */
class MediaCodeDefinition extends BBcodeDefinition
{
    protected $repository;
    protected $router;

    /**
     * @param MediaRepositoryInterface $repository
     */
    public function __construct(MediaRepositoryInterface $repository, RequestContextAwareInterface $router)
    {
        parent::__construct();
        $this->setTagName('media');
        $this->repository = $repository;
        $this->router = $router;
        $this->useOption = true;
    }

    /**
     * Returns this node as HTML
     *
     * @return string
     */
    public function asHtml(ElementNode $el)
    {
        $options = $el->getAttribute();
        if (!isset($options['id'])) {

            return '[media error: no media id]';
        } else {
            $media = $this->repository->find($options['id']);
            if ($media) {

                return $this->getHtml($media);
            } else {

                return '[media error: incorrect media id]';
            }
        }
    }

    protected function getHtml(MediaInterface $media)
    {
        $types = explode('/', $media->getMimeType());
        switch ($types[0]) {
            case 'image': // format
                return '<img src="'
                 //   . $this->router->getContext()->getBaseUrl() . '/'
                    . $this->router->generate(
                        'open_orchestra_media_get',
                        array('key' => $media->getId())
                    )
                    . '" title="' . $media->getTitle() . '" alt="' . $media->getAlt() . '">';
            default:
                return '';
        }
    }
}
