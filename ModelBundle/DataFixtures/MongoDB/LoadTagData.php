<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Tag;

/**
 * Class LoadTagData
 */
class LoadTagData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $tag1 = new Tag();
        $tag1->setLabel('Lorem');
        $manager->persist($tag1);

        $tag2 = new Tag();
        $tag2->setLabel('Ipsum');
        $manager->persist($tag2);

        $tag3 = new Tag();
        $tag3->setLabel('Dolor');
        $manager->persist($tag3);

        $tag4 = new Tag();
        $tag4->setLabel('Sit');
        $manager->persist($tag4);

        $tag5 = new Tag();
        $tag5->setLabel('Amet');
        $manager->persist($tag5);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 10;
    }

}
