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
    public function load(ObjectManager $manager)
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
        $site1->setDomain('front-phporchestra.dev');
        $site1->setAlias('front-phporchestra-front.inte');
        $site1->setDefaultLanguage('fr');
        $site1->setLanguages(array('en', 'fr'));
        $site1->setDeleted(true);
        $site1->setTheme($this->getReference('themePresentation'));
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
        $site2->setDomain('demo-phporchestra.dev');
        $site2->setAlias('demo-phporchestra-front.inte');
        $site2->setDefaultLanguage('fr');
        $site2->setLanguages(array('en', 'fr'));
        $site2->setDeleted(false);
        $site2->setTheme($this->getReference('themePresentation'));
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
        $site3->setDomain('echonext-phporchestra.dev');
        $site3->setAlias('echonext.phporchestra.inte');
        $site3->setDefaultLanguage('fr');
        $site3->setLanguages(array('en', 'fr'));
        $site3->setDeleted(false);
        $site3->setTheme($this->getReference('themePresentation'));
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
        $site4->setDomain('empty-orchestra.dev');
        $site4->setAlias('empty-php-orchestra.inte');
        $site4->setDefaultLanguage('fr');
        $site4->setLanguages(array('en', 'fr'));
        $site4->setDeleted(true);
        $site4->setTheme($this->getReference('themePresentation'));
        $site4->addBlock('sample');

        return $site4;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 300;
    }
}
