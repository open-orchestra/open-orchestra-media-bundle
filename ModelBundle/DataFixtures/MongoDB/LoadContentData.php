<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Content;
use PHPOrchestra\ModelBundle\Document\ContentAttribute;
use PHPOrchestra\ModelBundle\Model\StatusableInterface;

/**
 * Class LoadContentData
 */
class LoadContentData implements FixtureInterface
{
    /**
     * @param ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        $content1 = $this->generateContent1();
        $objectManager->persist($content1);

        $content2 = $this->generateContent2();
        $objectManager->persist($content2);

        $content3 = $this->generateContent3();
        $objectManager->persist($content3);

        $content4 = $this->generateContent4();
        $objectManager->persist($content4);

        $objectManager->flush();
    }

    /**
     * @return Content
     */
    public function generateContent1()
    {
        $content = new Content();

        $attribute1 = new ContentAttribute();
        $attribute1->setName('title');
        $attribute1->setValue("Bien vivre en France");

        $attribute2 = new ContentAttribute();
        $attribute2->setName('image');
        $attribute2->setValue("/apple-touch-icon.png");

        $attribute3 = new ContentAttribute();
        $attribute3->setName("intro");
        $attribute3->setValue("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non feugiat sem. Aliquam a mauris tellus. In hac habitasse platea dictumst. Nunc eget interdum ante, id mollis diam. Suspendisse sed magna lectus. Aenean fringilla elementum Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non feugiat sem. Aliquam a mauris tellus. In hac habitasse platea dictumst. Nunc eget interdum ante, id mollis diam. Suspendisse sed magna lectus. Aenean fringilla elementum lorem id suscipit. Phasellus feugiat tellus sapien, id tempus nisi ultrices ut.");

        $attribute4 = new ContentAttribute();
        $attribute4->setName("text");
        $attribute4->setValue("Cras non dui id neque mattis molestie. Quisque feugiat metus in est aliquet, nec convallis ante blandit. Suspendisse tincidunt tortor et tellus eleifend bibendum. Fusce fringilla mauris dolor, quis tempus diam tempus eu. Morbi enim orci, aliquam at sapien eu, dignissim commodo enim. Nulla ultricies erat non facilisis feugiat. Quisque fringilla ante lacus, vitae viverra magna aliquam non. Pellentesque quis diam suscipit, tincidunt felis eget, mollis mauris. Nulla facilisi.<br /><br />Nunc tincidunt pellentesque suscipit. Donec tristique massa at turpis fringilla, non aliquam ante luctus. Nam in felis tristique, scelerisque magna eget, sagittis purus. Maecenas malesuada placerat rutrum. Vestibulum sem urna, pharetra et fermentum a, iaculis quis augue. Ut ac neque mauris. In vel risus dui. Fusce lacinia a velit vitae condimentum.");

        $content->setContentId("1");
        $content->setContentType("news");
        $content->setContentTypeVersion(1);
        $content->setDeleted(false);
        $content->setName("Bien vivre en France");
        $content->setLanguage("fr");
        $content->setStatus(StatusableInterface::STATUS_PUBLISHED);
        $content->setVersion(1);

        $content->addAttribute($attribute1);
        $content->addAttribute($attribute2);
        $content->addAttribute($attribute3);
        $content->addAttribute($attribute4);

        return $content;
    }

    /**
     * @return Content
     */
    public function generateContent2()
    {
        $content = new Content();

        $attribute1 = new ContentAttribute();
        $attribute1->setName("title");
        $attribute1->setValue("lorem Ipsum");

        $attribute2 = new ContentAttribute();
        $attribute2->setName("image");
        $attribute2->setValue("");

        $attribute3 = new ContentAttribute();
        $attribute3->setName("intro");
        $attribute3->setValue("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non feugiat sem. Aliquam a mauris tellus. In hac habitasse platea dictumst. Nunc eget interdum ante, id mollis diam. Suspendisse sed magna lectus. Aenean fringilla elementum lorem id suscipit. Phasellus feugiat tellus sapien, id tempus nisi ultrices ut.");

        $attribute4 = new ContentAttribute();
        $attribute4->setName("text");
        $attribute4->setValue("Cras non dui id neque mattis molestie. Quisque feugiat metus in est aliquet, nec convallis ante blandit. Suspendisse tincidunt tortor et tellus eleifend bibendum. Fusce fringilla mauris dolor, quis tempus diam tempus eu. Morbi enim orci, aliquam at sapien eu, dignissim commodo enim. Nulla ultricies erat non facilisis feugiat. Quisque fringilla ante lacus, vitae viverra magna aliquam non. Pellentesque quis diam suscipit, tincidunt felis eget, mollis mauris. Nulla facilisi.<br /><br />Nunc tincidunt pellentesque suscipit. Donec tristique massa at turpis fringilla, non aliquam ante luctus. Nam in felis tristique, scelerisque magna eget, sagittis purus. Maecenas malesuada placerat rutrum. Vestibulum sem urna, pharetra et fermentum a, iaculis quis augue. Ut ac neque mauris. In vel risus dui. Fusce lacinia a velit vitae condimentum.");

        $content->setContentId("2");
        $content->setContentType("news");
        $content->setContentTypeVersion(1);
        $content->setDeleted(false);
        $content->setName("Lorem ipsum");
        $content->setLanguage("fr");
        $content->setStatus(StatusableInterface::STATUS_PUBLISHED);
        $content->setVersion(1);

        $content->addAttribute($attribute1);
        $content->addAttribute($attribute2);
        $content->addAttribute($attribute3);
        $content->addAttribute($attribute4);

        return $content;
    }

    /**
     * @return Content
     */
    public function generateContent3()
    {
        $content = new Content();

        $attribute1 = new ContentAttribute();
        $attribute1->setName("name");
        $attribute1->setValue("R5 3 doors");

        $attribute2 = new ContentAttribute();
        $attribute2->setName("image");
        $attribute2->setValue("r5.png");

        $attribute3 = new ContentAttribute();
        $attribute3->setName("description");
        $attribute3->setValue("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean non feugiat sem. Aliquam a mauris tellus. In hac habitasse platea dictumst. Nunc eget interdum ante, id mollis diam. Suspendisse sed magna lectus. Aenean fringilla elementum lorem id suscipit. Phasellus feugiat tellus sapien, id tempus nisi ultrices ut.");

        $content->setContentId("3");
        $content->setContentType("car");
        $content->setContentTypeVersion(1);
        $content->setDeleted(false);
        $content->setName("R5 3 portes");
        $content->setLanguage("en");
        $content->setStatus(StatusableInterface::STATUS_PUBLISHED);
        $content->setVersion(2);

        $content->addAttribute($attribute1);
        $content->addAttribute($attribute2);
        $content->addAttribute($attribute3);

        return $content;
    }

    /**
     * @return Content
     */
    public function generateContent4()
    {
        $content = new Content();

        $attribute1 = new ContentAttribute();
        $attribute1->setName("firstname");
        $attribute1->setValue("Jean-Claude");

        $attribute2 = new ContentAttribute();
        $attribute2->setName("lastname");
        $attribute2->setValue("Convenant");

        $attribute3 = new ContentAttribute();
        $attribute3->setName("identifier");
        $attribute3->setValue(28);

        $content->setContentId("4");
        $content->setContentType("customer");
        $content->setContentTypeVersion(1);
        $content->setDeleted(false);
        $content->setName("Jean-Paul");
        $content->setLanguage("fr");
        $content->setStatus(StatusableInterface::STATUS_PUBLISHED);
        $content->setVersion(2);

        $content->addAttribute($attribute1);
        $content->addAttribute($attribute2);
        $content->addAttribute($attribute3);

        return $content;
    }
}
