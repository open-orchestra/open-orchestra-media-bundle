<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Area;
use PHPOrchestra\ModelBundle\Document\Block;
use PHPOrchestra\ModelBundle\Document\Node;
use PHPOrchestra\ModelBundle\Model\NodeInterface;

/**
 * Class LoadNodeData
 */
class LoadNodeData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $home = $this->generateNodeHome();
        $manager->persist($home);

        $full = $this->genereFullFixture();
        $manager->persist($full);

        $manager->flush();
    }

    /**
     * @return Node
     */
    protected function generateNodeHome()
    {
        $homeBlock = new Block();
        $homeBlock->setComponent('Sample');
        $homeBlock->setAttributes(array(
            'title' => 'Accueil',
            'news' => "Bienvenu sur le site de démo issu des fixtures.",
            'author' => ''
        ));

        $homeArea = new Area();
        $homeArea->setAreaId('main');
        $homeArea->setBlocks(array(array('nodeId' => 0, 'blockId' => 0)));

        $home = new Node();
        $home->setNodeId('root');
        $home->setNodeType('page');
        $home->setSiteId(1);
        $home->setParentId('-');
        $home->setAlias('-');
        $home->setPath('-');
        $home->setName('Fixuter Home');
        $home->setVersion(1);
        $home->setLanguage('fr');
        $home->setStatus('published');
        $home->setDeleted(false);
        $home->setTemplateId('template_main');
        $home->setTheme('theme1');
        $home->setInMenu(true);
        $home->setInFooter(false);
        $home->addArea($homeArea);
        $home->addBlock($homeBlock);

        return $home;
    }

    /**
     * @return Node
     */
    protected function genereFullFixture()
    {
        $block0 = new Block();
        $block0->setComponent('Sample');
        $block0->setAttributes(array(
            'title' => 'Qui sommes-nous?',
            'author' => 'Pourquoi nous choisir ?',
            'news' => 'Nos agences'
        ));

        $block1 = new Block();
        $block1->setComponent('Menu');
        $block1->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'idmenu',
        ));

        $block2 = new Block();
        $block2->setComponent('Sample');
        $block2->setAttributes(array(
            "title" => "News 1",
            "author" => "Donec bibendum at nibh eget imperdiet. Mauris eget justo augue. Fusce fermentum iaculis erat, sollicitudin elementum enim sodales eu. Donec a ante tortor. Suspendisse a.",
            "news" => ""
        ));

        $block3 = new Block();
        $block3->setComponent('Sample');
        $block3->setAttributes(array(
            "title" => "News #2",
            "author" => "Aliquam convallis facilisis nulla, id ultricies ipsum cursus eu. Proin augue quam, iaculis id nisi ac, rutrum blandit leo. In leo ante, scelerisque tempus lacinia in, sollicitudin quis justo. Vestibulum.",
            "news" => ""
        ));

        $block4 = new Block();
        $block4->setComponent('Sample');
        $block4->setAttributes(array(
            "title" => "News #3",
            "author" => "Phasellus condimentum diam placerat varius iaculis. Aenean dictum, libero in sollicitudin hendrerit, nulla mi elementum massa, eget mattis lorem enim vel magna. Fusce suscipit orci vitae vestibulum.",
            "news" => ""
        ));

        $block5 = new Block();
        $block5->setComponent('Sample');
        $block5->setAttributes(array(
            'title' => 'mapub.jpg',
            'author' => 'bépo',
            'news' => ''
        ));

        $block6 = new Block();
        $block6->setComponent('Footer');
        $block6->setAttributes(array(
            'id' => 'idFooter',
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            )
        ));

        $block7 = new Block();
        $block7->setComponent('Search');
        $block7->setAttributes(array(
            'value' => 'Rechercher',
            'class' => 'classbouton',
            'nodeId' => 'fixture_search',
            'limit' => 8
        ));

        $headerArea = new Area();
        $headerArea->setAreaId('header');
        $headerArea->setBlocks(array(array('nodeId' => 0, 'blockId' => 0)));

        $leftMenuArea = new Area();
        $leftMenuArea->setAreaId('left_menu');
        $leftMenuArea->setBlocks(array(array('nodeId' => 0, 'blockId' => 1)));

        $contentArea = new Area();
        $contentArea->setAreaId('content');
        $contentArea->setBlocks(array(
            array('nodeId' => 0, 'blockId' => 2),
            array('nodeId' => 0, 'blockId' => 3),
            array('nodeId' => 0, 'blockId' => 4),
        ));

        $skycrapperArea = new Area();
        $skycrapperArea->setAreaId('skycrapper');
        $skycrapperArea->setBlocks(array(array('nodeId' => 0, 'blockId' => 5)));

        $mainArea = new Area();
        $mainArea->setAreaId('main');
        $mainArea->setBoDirection('v');
        $mainArea->addSubArea($leftMenuArea);
        $mainArea->addSubArea($contentArea);
        $mainArea->addSubArea($skycrapperArea);

        $footerArea = new Area();
        $footerArea->setAreaId('footer');
        $footerArea->setBlocks(array(array('nodeId' => 0, 'blockId' => 6)));

        $searchArea = new Area();
        $searchArea->setAreaId('Search');
        $searchArea->setBlocks(array(array('nodeId' => 0, 'blockId' => 7)));

        $full = new Node();
        $full->setNodeId('fixture_full');
        $full->setNodeType('page');
        $full->setSiteId(1);
        $full->setParentId('root');
        $full->setPath('-');
        $full->setAlias('fixture-full');
        $full->setName('Fixture full sample');
        $full->setVersion(1);
        $full->setLanguage('fr');
        $full->setStatus(NodeInterface::PUBLISHED);
        $full->setDeleted(false);
        $full->setTemplateId('template_full');
        $full->setTheme('mixed');
        $full->setInMenu(true);
        $full->setInFooter(false);
        $full->addArea($headerArea);
        $full->addArea($mainArea);
        $full->addArea($footerArea);
        $full->addArea($searchArea);
        $full->addBlock($block0);
        $full->addBlock($block1);
        $full->addBlock($block2);
        $full->addBlock($block3);
        $full->addBlock($block4);
        $full->addBlock($block5);
        $full->addBlock($block6);
        $full->addBlock($block7);

        return $full;
    }

}
