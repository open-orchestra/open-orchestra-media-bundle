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
    function load(ObjectManager $manager)
    {
        $generic = $this->genericTemplate();
        $manager->persist($generic);

        $full = $this->fullTemplate();
        $manager->persist($full);

        $template = $this->mainTemplate();
        $manager->persist($template);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 40;
    }

    /**
     * @return Template
     */
    protected function genericTemplate()
    {
        $genericArea = new Area();
        $genericArea->setAreaId('Generic area');

        $generic = new Template();
        $generic->setTemplateId('template_generic');
        $generic->setSiteId('1');
        $generic->setVersion(1);
        $generic->setName('Generic Template');
        $generic->setLanguage('fr');
        $generic->setStatus($this->getReference('status-published'));
        $generic->setDeleted(false);
        $generic->setBoDirection('h');
        $generic->addArea($genericArea);

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

        $content = new Area();
        $content->setAreaId('content');

        $skycrapper = new Area();
        $skycrapper->setAreaId('skycrapper');

        $main = new Area();
        $main->setAreaId('main');
        $main->setBoDirection('v');
        $main->addArea($leftMenu);
        $main->addArea($content);
        $main->addArea($skycrapper);

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
        $full->addArea($main);
        $full->addArea($footer);

        return $full;
    }

    /**
     * @return Template
     */
    protected function mainTemplate()
    {
        $main = new Area();
        $main->setAreaId('main');

        $template = new Template();
        $template->setTemplateId('template_main');
        $template->setSiteId('1');
        $template->setVersion(1);
        $template->setName('Generic Main');
        $template->setLanguage('fr');
        $template->setStatus($this->getReference('status-published'));
        $template->setBoDirection('h');
        $template->setDeleted(false);
        $template->addArea($main);

        return $template;
    }

}
