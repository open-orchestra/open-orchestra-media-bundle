<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Area;
use PHPOrchestra\ModelBundle\Document\Template;

/**
 * Class LoadTemplateData
 */
class LoadTemplateData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $generic = $this->homepageTemplate();
        $manager->persist($generic);

        $full = $this->fullTemplate();
        $manager->persist($full);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 210;
    }

    /**
     * @return Template
     */
    protected function homepageTemplate()
    {
        $header = new Area();
        $header->setAreaId('header');
        $main = new Area();
        $main->setAreaId('main');
        $footer = new Area();
        $footer->setAreaId('footer');

        $generic = new Template();
        $generic->setTemplateId('template_home');
        $generic->setSiteId('1');
        $generic->setVersion(1);
        $generic->setName('Homepage Template');
        $generic->setLanguage('fr');
        $generic->setStatus($this->getReference('status-published'));
        $generic->setDeleted(false);
        $generic->setBoDirection('h');
        $generic->addArea($header);
        $generic->addArea($main);
        $generic->addArea($footer);

        return $generic;
    }

    /**
     * @return Template
     */
    protected function fullTemplate()
    {
        $header = new Area();
        $header->setAreaId('header');

        $leftMenu = new Area();
        $leftMenu->setAreaId('left_menu');

        $main = new Area();
        $main->setAreaId('main');

        $body = new Area();
        $body->setAreaId('body');
        $body->setBoDirection('v');
        $body->addArea($leftMenu);
        $body->addArea($main);

        $footer = new Area();
        $footer->setAreaId('footer');

        $full = new Template();
        $full->setTemplateId('template_full');
        $full->setSiteId('1');
        $full->setVersion(1);
        $full->setName('Full Template');
        $full->setLanguage('fr');
        $full->setStatus($this->getReference('status-published'));
        $full->setBoDirection('h');
        $full->setDeleted(false);
        $full->addArea($header);
        $full->addArea($body);
        $full->addArea($footer);

        return $full;
    }
}
