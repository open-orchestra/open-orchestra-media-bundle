<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\ODM\MongoDB\Mapping\Annotations\String;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Content;
use PHPOrchestra\ModelBundle\Document\ContentAttribute;

/**
 * Class LoadContentData
 */
class LoadContentData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $objectManager
     */
    public function load(ObjectManager $objectManager)
    {
        $content3 = $this->generateContent3();
        $objectManager->persist($content3);

        $content4 = $this->generateContent4();
        $objectManager->persist($content4);

        $objectManager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 71;
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
        $content->setStatus($this->getReference('status-published'));
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
        $content->setStatus($this->getReference('status-published'));
        $content->setVersion(2);

        $content->addAttribute($attribute1);
        $content->addAttribute($attribute2);
        $content->addAttribute($attribute3);

        return $content;
    }
}
