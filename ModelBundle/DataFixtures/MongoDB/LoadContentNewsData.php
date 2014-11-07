<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\ODM\MongoDB\Mapping\Annotations\String;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Content;
use PHPOrchestra\ModelBundle\Document\ContentAttribute;

/**
 * Class LoadContentNewsData
 */
class LoadContentNewsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        $objectManager->persist($this->generateBienvenueFrance());
        $objectManager->persist($this->generateLoremIpsum());

        $objectManager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 70;
    }

    /**
     * Generate a content attribute
     * 
     * @param string $name
     * @param string $value
     * 
     * @return ContentAttribute
     */
    protected function generateContentAttribute($name, $value)
    {
        $attribute = new ContentAttribute();
        $attribute->setName($name);
        $attribute->setValue($value);

        return $attribute;
    }

    /**
     * Generate a content
     * 
     * @param string $type
     * @param int $id
     * @param string $name
     * @param string $language
     * 
     * @return Content
     */
    protected function generateContent($type, $id, $name, $language)
    {
        $content = new Content();

        $content->setContentId($id);
        $content->setContentType($type);
        $content->setContentTypeVersion(1);
        $content->setDeleted(false);
        $content->setName($name);
        $content->setLanguage($language);
        $content->setStatus($this->getReference('status-published'));
        $content->setVersion(1);

        return $content;
    }

    /**
     * Fill news attributes
     * 
     * @param Content $news
     * @param ContentAttribute $title
     * @param ContentAttribute $start
     * @param ContentAttribute $end
     * @param ContentAttribute $image
     * @param ContentAttribute $intro
     * @param ContentAttribute $text
     * 
     * @return Content
     */
    protected function addNewsAttributes($news, $title, $start, $end, $image, $intro, $text)
    {
        $news->addAttribute($title);
        $news->addAttribute($start);
        $news->addAttribute($end);
        $news->addAttribute($image);
        $news->addAttribute($intro);
        $news->addAttribute($text);

        return $news;
    }

    /**
     * @return Content
     */
    public function generateBienvenueFrance()
    {
        $title = $this->generateContentAttribute('title', 'Bien vivre en France');
        $image = $this->generateContentAttribute('image', '');
        $intro = $this->generateContentAttribute('intro', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non feugiat sem. Aliquam a mauris tellus. In hac habitasse platea dictumst. Nunc eget interdum ante, id mollis diam. Suspendisse sed magna lectus. Aenean fringilla elementum Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non feugiat sem. Aliquam a mauris tellus. In hac habitasse platea dictumst. Nunc eget interdum ante, id mollis diam. Suspendisse sed magna lectus. Aenean fringilla elementum lorem id suscipit. Phasellus feugiat tellus sapien, id tempus nisi ultrices ut.');
        $text = $this->generateContentAttribute('text', 'Cras non dui id neque mattis molestie. Quisque feugiat metus in est aliquet, nec convallis ante blandit. Suspendisse tincidunt tortor et tellus eleifend bibendum. Fusce fringilla mauris dolor, quis tempus diam tempus eu. Morbi enim orci, aliquam at sapien eu, dignissim commodo enim. Nulla ultricies erat non facilisis feugiat. Quisque fringilla ante lacus, vitae viverra magna aliquam non. Pellentesque quis diam suscipit, tincidunt felis eget, mollis mauris. Nulla facilisi.<br /><br />Nunc tincidunt pellentesque suscipit. Donec tristique massa at turpis fringilla, non aliquam ante luctus. Nam in felis tristique, scelerisque magna eget, sagittis purus. Maecenas malesuada placerat rutrum. Vestibulum sem urna, pharetra et fermentum a, iaculis quis augue. Ut ac neque mauris. In vel risus dui. Fusce lacinia a velit vitae condimentum.');
        $start = $this->generateContentAttribute('publish_start', '2014-07-25');
        $end = $this->generateContentAttribute('publish_end', '2014-10-19');

        $bienvenueFrance = $this->generateContent('news', 1, 'Bien vivre en France', 'fr');
        return $this->addNewsAttributes($bienvenueFrance, $title, $start, $end, $image, $intro, $text);
    }

    /**
     * @return Content
     */
    public function generateLoremIpsum()
    {
        $title = $this->generateContentAttribute('title', 'lorem Ipsum');
        $image = $this->generateContentAttribute('image', '');
        $intro = $this->generateContentAttribute('intro', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non feugiat sem. Aliquam a mauris tellus. In hac habitasse platea dictumst. Nunc eget interdum ante, id mollis diam. Suspendisse sed magna lectus. Aenean fringilla elementum lorem id suscipit. Phasellus feugiat tellus sapien, id tempus nisi ultrices ut.');
        $text = $this->generateContentAttribute('text', 'Cras non dui id neque mattis molestie. Quisque feugiat metus in est aliquet, nec convallis ante blandit. Suspendisse tincidunt tortor et tellus eleifend bibendum. Fusce fringilla mauris dolor, quis tempus diam tempus eu. Morbi enim orci, aliquam at sapien eu, dignissim commodo enim. Nulla ultricies erat non facilisis feugiat. Quisque fringilla ante lacus, vitae viverra magna aliquam non. Pellentesque quis diam suscipit, tincidunt felis eget, mollis mauris. Nulla facilisi.<br /><br />Nunc tincidunt pellentesque suscipit. Donec tristique massa at turpis fringilla, non aliquam ante luctus. Nam in felis tristique, scelerisque magna eget, sagittis purus. Maecenas malesuada placerat rutrum. Vestibulum sem urna, pharetra et fermentum a, iaculis quis augue. Ut ac neque mauris. In vel risus dui. Fusce lacinia a velit vitae condimentum.');
        $start = $this->generateContentAttribute('publish_start', '2014-08-25');
        $end = $this->generateContentAttribute('publish_end', '2014-11-19');

        $loremIpsum = $this->generateContent('news', 2, 'Lorem ipsum', 'fr');
        return $this->addNewsAttributes($loremIpsum, $title, $start, $end, $image, $intro, $text);
    }
}
