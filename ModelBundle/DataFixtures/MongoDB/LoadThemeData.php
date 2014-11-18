<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Theme;

/**
 * Class LoadThemeData
 */
class LoadThemeData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $theme = new Theme();
        $theme->setName('themePresentation');
        $manager->persist($theme);

        $theme = new Theme();
        $theme->setName('echonext');
        $manager->persist($theme);

        $manager->flush();
    }

}
