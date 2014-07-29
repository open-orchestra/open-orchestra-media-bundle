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

        $generic = $this->generateGenericNode();
        $manager->persist($generic);

        $aboutUs = $this->generateAboutUsNode();
        $manager->persist($aboutUs);

        $bd = $this->generateBdNode();
        $manager->persist($bd);

        $interakting = $this->generateInteraktingNode();
        $manager->persist($interakting);

        $contactUs = $this->generateContactUsNode();
        $manager->persist($contactUs);

        $directory = $this->generateDirectoryNode();
        $manager->persist($directory);

        $search = $this->generateSearchNode();
        $manager->persist($search);

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

    /**
     * @return Node
     */
    protected function generateGenericNode()
    {
        $genericArea = new Area();
        $genericArea->setAreaId('Generic Area');

        $generic = new Node();
        $generic->setNodeId('fixutre_generic');
        $generic->setNodeType('page');
        $generic->setSiteId(1);
        $generic->setParentId('root');
        $generic->setPath('-');
        $generic->setAlias('fixture-generic');
        $generic->setName('Generic Node');
        $generic->setVersion(1);
        $generic->setLanguage('fr');
        $generic->setStatus('published');
        $generic->setTemplateId('template_generic');
        $generic->setDeleted(true);
        $generic->setInMenu(true);
        $generic->setInFooter(false);
        $generic->addArea($genericArea);
        return $generic;
    }

    /**
     * @return Node
     */
    protected function generateAboutUsNode()
    {
        $aboutUsBlock = new Block();
        $aboutUsBlock->setComponent('Sample');
        $aboutUsBlock->setAttributes(array(
            'title' => 'Qui sommes-nous?',
            'author' => 'Pour tout savoir sur notre entreprise.',
            'news' => ''
        ));

        $aboutUsArea = new Area();
        $aboutUsArea->setAreaId('main');
        $aboutUsArea->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $aboutUs = new Node();
        $aboutUs->setNodeId('fixture_about_us');
        $aboutUs->setNodeType('page');
        $aboutUs->setName('Fixture About Us');
        $aboutUs->setSiteId(1);
        $aboutUs->setParentId('root');
        $aboutUs->setPath('-');
        $aboutUs->setAlias('qui-sommes-nous');
        $aboutUs->setVersion(1);
        $aboutUs->setLanguage('fr');
        $aboutUs->setStatus('published');
        $aboutUs->setDeleted(false);
        $aboutUs->setTemplateId('template_main');
        $aboutUs->setTheme('theme2');
        $aboutUs->setInFooter(true);
        $aboutUs->setInMenu(true);
        $aboutUs->addArea($aboutUsArea);
        $aboutUs->addBlock($aboutUsBlock);
        return $aboutUs;
    }

    /**
     * @return Node
     */
    protected function generateBdNode()
    {
        $bdBlock = new Block();
        $bdBlock->setComponent('Sample');
        $bdBlock->setAttributes(array(
            'title' => 'B&D',
            'author' => 'Tout sur B&D',
            'news' => ''
        ));

        $bdArea = new Area();
        $bdArea->setAreaId('main');
        $bdArea->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $bd = new Node();
        $bd->setNodeId('fixture_bd');
        $bd->setNodeType('page');
        $bd->setName('Fixture B&D');
        $bd->setSiteId(1);
        $bd->setParentId('fixture_about_us');
        $bd->setPath('-');
        $bd->setAlias('b-et-d');
        $bd->setVersion(1);
        $bd->setLanguage('fr');
        $bd->setStatus('published');
        $bd->setDeleted(false);
        $bd->setTemplateId('template_main');
        $bd->setTheme('theme2');
        $bd->setInFooter(true);
        $bd->setInMenu(true);
        $bd->addArea($bdArea);
        $bd->addBlock($bdBlock);

        return $bd;
    }

    /**
     * @return Node
     */
    protected function generateInteraktingNode()
    {
        $interaktingBlock = new Block();
        $interaktingBlock->setComponent('Sample');
        $interaktingBlock->setAttributes(array(
            'title' => 'Interakting',
            'author' => '',
            'news' => 'Des trucs sur Interakting (non versionnés)'
        ));

        $interaktingArea = new Area();
        $interaktingArea->setAreaId('main');
        $interaktingArea->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $interakting = new Node();
        $interakting->setNodeId('fixture_interakting');
        $interakting->setNodeType('page');
        $interakting->setName('Fixture Interakting');
        $interakting->setSiteId(1);
        $interakting->setParentId('fixture_about_us');
        $interakting->setPath('-');
        $interakting->setAlias('interakting');
        $interakting->setVersion(1);
        $interakting->setLanguage('fr');
        $interakting->setStatus('published');
        $interakting->setDeleted(false);
        $interakting->setTemplateId('template_main');
        $interakting->setTheme('sample');
        $interakting->setInFooter(true);
        $interakting->setInMenu(true);
        $interakting->addArea($interaktingArea);
        $interakting->addBlock($interaktingBlock);

        return $interakting;
    }

    /**
     * @return Node
     */
    protected function generateContactUsNode()
    {
        $contactUsBlock = new Block();
        $contactUsBlock->setComponent('Sample');
        $contactUsBlock->setAttributes(array(
            'title' => 'Nous contacter',
            'author' => 'Comment nous contacter',
            'news' => 'swgsdwgh',
            'contentType' => 'news'
        ));

        $contactUsArea = new Area();
        $contactUsArea->setAreaId('main');
        $contactUsArea->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $contactUs = new Node();
        $contactUs->setNodeId('fixture_contact_us');
        $contactUs->setNodeType('page');
        $contactUs->setName('Fixture Contact Us');
        $contactUs->setSiteId(1);
        $contactUs->setParentId('root');
        $contactUs->setPath('-');
        $contactUs->setAlias('nous-contacter');
        $contactUs->setVersion(1);
        $contactUs->setLanguage('fr');
        $contactUs->setStatus('published');
        $contactUs->setDeleted(false);
        $contactUs->setTemplateId('template_main');
        $contactUs->setTheme('theme1');
        $contactUs->setInFooter(true);
        $contactUs->setInMenu(false);
        $contactUs->addArea($contactUsArea);
        $contactUs->addBlock($contactUsBlock);

        return $contactUs;
    }

    /**
     * @return Node
     */
    protected function generateDirectoryNode()
    {
        $directoryBlock = new Block();
        $directoryBlock->setComponent('Sample');
        $directoryBlock->setAttributes(array(
            'title' => 'Annuaire',
            'author' => 'Le bottin mondain',
            'news' => '',
            'contentType' => 'car'
        ));

        $directoryArea = new Area();
        $directoryArea->setAreaId('main');
        $directoryArea->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $directory = new Node();
        $directory->setNodeId('fixture_directory');
        $directory->setNodeType('directory');
        $directory->setName('Fixture Directory');
        $directory->setSiteId(1);
        $directory->setParentId('root');
        $directory->setPath('-');
        $directory->setAlias('nous-contacter');
        $directory->setVersion(1);
        $directory->setLanguage('fr');
        $directory->setStatus('published');
        $directory->setDeleted(false);
        $directory->setTemplateId('template_main');
        $directory->setTheme('fromApp');
        $directory->setInFooter(true);
        $directory->setInMenu(false);
        $directory->addArea($directoryArea);
        $directory->addBlock($directoryBlock);

        return $directory;
    }

    /**
     * @return Node
     */
    protected function generateSearchNode()
    {
        $searchBlock0 = new Block();
        $searchBlock0->setComponent('Sample');
        $searchBlock0->setAttributes(array(
            'title' => 'Qui somme-nous?',
            'author' => 'Pourquoi nous choisir ?',
            'news' => 'Nos agences'
        ));

        $searchBlock1 = new Block();
        $searchBlock1->setComponent('Menu');
        $searchBlock1->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'idmenu',
        ));

        $searchBlock2 = new Block();
        $searchBlock2->setComponent('Search');
        $searchBlock2->setAttributes(array(
            'value' => 'Rechercher',
            'name' => "btnSearch",
            'class' => 'classbouton',
            'nodeId' => 'fixture_search'
        ));

        $searchBlock3 = new Block();
        $searchBlock3->setComponent('SearchResult');
        $searchBlock3->setAttributes(array(
            'nodeId' => 'fixture_search',
            'nbdoc' => '5',
            'fielddisplayed' => array(
                "title_s", "news_t", "author_s", "title_t", "intro_t", "text_t", "description_t",
            ),
            "facets" => array(
                "facetField" => array(
                    "name" =>"parent",
                    "field" => "parentId",
                    "options" => array()
                )
            ),
            "filter" => array(),
            "nbspellcheck" => "6",
            "optionsearch" => array(),
            "optionsdismax" => array(
                "fields" => array(
                    "author_s", "intro_t", "title_s"
                ),
                "boost" => array(
                    "2", "1.5", "1"
                ),
                "mm" => "75%"
            )
        ));

        $searchBlock4 = new Block();
        $searchBlock4->setComponent('Footer');
        $searchBlock4->setAttributes(array(
            'id' => 'idFooter',
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
        ));

        $searchArea0 = new Area();
        $searchArea0->setAreaId('header');
        $searchArea0->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $leftMenuArea = new Area();
        $leftMenuArea->setAreaId('left_menu');
        $leftMenuArea->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $contentArea = new Area();
        $contentArea->setAreaId('content');
        $contentArea->addBlock(array('nodeId' => 0, 'blockId' => 2));
        $contentArea->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $searchArea1 = new Area();
        $searchArea1->setAreaId('main');
        $searchArea1->setBoDirection('v');
        $searchArea1->addSubArea($leftMenuArea);
        $searchArea1->addSubArea($contentArea);


        $searchArea2 = new Area();
        $searchArea2->setAreaId('footer');
        $searchArea2->addBlock(array('nodeId' => 0, 'blockId' => 4));

        $search = new Node();
        $search->setNodeId('fixture_search');
        $search->setNodeType('search');
        $search->setName('Fixture Search');
        $search->setSiteId(1);
        $search->setParentId('root');
        $search->setPath('-');
        $search->setAlias('nous-contacter');
        $search->setVersion(1);
        $search->setLanguage('fr');
        $search->setStatus('published');
        $search->setDeleted(false);
        $search->setTemplateId('template_main');
        $search->setTheme('fromApp');
        $search->setInFooter(true);
        $search->setInMenu(false);
        $search->addArea($searchArea0);
        $search->addArea($searchArea1);
        $search->addArea($searchArea2);
        $search->addBlock($searchBlock0);
        $search->addBlock($searchBlock1);
        $search->addBlock($searchBlock2);
        $search->addBlock($searchBlock3);
        $search->addBlock($searchBlock4);

        return $search;
    }
}
