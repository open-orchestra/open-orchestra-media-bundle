<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Site;

/**
 * Class LoadSiteData
 */
class LoadSiteData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $site1 = $this->getSite1();
        $manager->persist($site1);
        $this->addReference('site1', $site1);

        $site2 = $this->getSite2();
        $manager->persist($site2);
        $this->addReference('site2', $site2);

        $site3 = $this->getSite3();
        $manager->persist($site3);
        $this->addReference('site3', $site3);

        $site4 = $this->getSite4();
        $manager->persist($site4);
        $this->addReference('site4', $site4);

        $manager->flush();
    }

    /**
     * @return Site
     */
    protected function getSite1()
    {
        $site1 = new Site();
        $site1->setSiteId('1');
        $site1->setDomain('www.aphpOrchestra.fr');
        $site1->setAlias('www.ophp-orchestra.fr');
        $site1->setDefaultLanguage('fr');
        $site1->setLanguages(array('en', 'fr'));
        $site1->addBlock('sample');

        return $site1;
    }

    /**
     * @return Site
     */
    protected function getSite2()
    {
        $site2 = new Site();
        $site2->setSiteId('2');
        $site2->setDomain('www.bphpOrchestra.fr');
        $site2->setAlias('www.nphp-orchestra.fr');
        $site2->setDefaultLanguage('fr');
        $site2->setLanguages(array('en', 'fr'));
        $site2->addBlock('sample');

        return $site2;
    }

    /**
     * @return Site
     */
    protected function getSite3()
    {
        $site3 = new Site();
        $site3->setSiteId('3');
        $site3->setDomain('www.cphpOrchestra.fr');
        $site3->setAlias('www.mphp-orchestra.fr');
        $site3->setDefaultLanguage('fr');
        $site3->setLanguages(array('en', 'fr'));
        $site3->addBlock('sample');

        return $site3;
    }

    /**
     * @return Site
     */
    protected function getSite4()
    {
        $site4 = new Site();
        $site4->setSiteId('4');
        $site4->setDomain('www.dphpOrchestra.fr');
        $site4->setAlias('www.lphp-orchestra.fr');
        $site4->setDefaultLanguage('fr');
        $site4->setLanguages(array('en', 'fr'));
        $site4->addBlock('sample');

        return $site4;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 25;
    }
}
