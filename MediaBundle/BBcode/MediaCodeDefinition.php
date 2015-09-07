<?php 

namespace OpenOrchestra\MediaBundle\BBcode;

use OpenOrchestra\Media\Repository\MediaRepositoryInterface;
use OpenOrchestra\BBcodeBundle\Definition\BBcodeDefinition;
use OpenOrchestra\BBcodeBundle\Node\BBcodeElementNodeInterface;
use JBBCode\ElementNode;

/**
 * Class MediaCodeDefinition
 */
class MediaCodeDefinition extends BBcodeDefinition
{
    protected $repository;

    /**
     * @param MediaRepositoryInterface $repository
     */
    public function __construct(MediaRepositoryInterface $repository)
    {
        parent::__construct();
        $this->setTagName('media');
        $this->repository = $repository;
        $this->useOption = true;
    }

    /**
     * Returns this node as HTML
     *
     * @return string
     */
    public function asHtml(ElementNode $el)
    {
//        if (!$this->hasValidInputs($el)) {
//            return $el->getAsBBCode();
//        }
//
//        $html = $this->getReplacementText();
//
//        if ($this->usesOption()) {
//            $options = $el->getAttribute();
//            if (count($options)==1){
//                $vals = array_values($options);
//                $html = str_ireplace('{option}', reset($vals), $html);
//            } else {
//                foreach ($options as $key => $val){
//                    $html = str_ireplace('{' . $key . '}', $val, $html);
//                }
//            }
//        }
//
//        $content = $this->getContent($el);
//
//        $html = str_ireplace('{param}', $content, $html);
//
//        return $html;

        $options = $el->getAttribute();
        if (!isset($options['id'])) {

            return $el->getAsBBCode();
        } else {
            $media = $this->repository->find(new \MongoId($options['id']));
        	var_dump($media);
            return "TOTO";
        }
    }
}
