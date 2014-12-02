<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Theme;

/**
 * Class LoadThemeData
 */
class LoadThemeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $theme1 = new Theme();
        $theme1->setName('themePresentation');
        $manager->persist($theme1);
        $this->addReference('themePresentation', $theme1);

        $theme2 = new Theme();
        $theme2->setName('echonext');
        $manager->persist($theme2);
        $this->addReference('echonext', $theme2);

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
