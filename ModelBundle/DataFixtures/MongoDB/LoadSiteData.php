<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Site;

/**
 * Class LoadSiteData
 */
class LoadSiteData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $site1 = new Site();
        $site1->setSiteId(1);
        $site1->setDomain('www.aphpOrchestra.fr');
        $site1->setAlias('www.ophp-orchestra.fr');
        $site1->setDefaultLanguage('fr');
        $site1->setLanguages(array('en', 'fr'));
        $site1->addBlock('Sample');

        $manager->persist($site1);

        $manager->flush();
    }

}
