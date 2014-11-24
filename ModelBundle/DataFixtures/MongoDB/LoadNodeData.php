<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\DisplayBundle\DisplayBlock\DisplayBlockInterface;
use PHPOrchestra\ModelBundle\Document\Area;
use PHPOrchestra\ModelBundle\Document\Block;
use PHPOrchestra\ModelBundle\Document\Node;
use PHPOrchestra\ModelBundle\Model\NodeInterface;

/**
 * Class LoadNodeData
 */
class LoadNodeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $home = $this->generateNodeHome(1);
        $manager->persist($home);
        $home2 = $this->generateNodeHome(2);
        $manager->persist($home2);
        $home2 = $this->generateNodeHome(3, 'status-draft');
        $manager->persist($home2);

        $homeEn = $this->generateNodeHomeEn();
        $manager->persist($homeEn);

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
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 50;
    }

    /**
     * @return Node
     */
    protected function generateNodeHome($version, $status = 'status-published')
    {
        $homeBlock = new Block();
        $homeBlock->setLabel('Home');
        $homeBlock->setComponent('sample');
        $homeBlock->setAttributes(array(
            'title' => 'Accueil',
            'news' => "Bienvenu sur le site de démo issu des fixtures.",
            'author' => ''
        ));
        $homeBlock->addArea(array('nodeId' => NodeInterface::ROOT_NODE_ID, 'areaId' => 'main'));

        $loginBlock = new Block();
        $loginBlock->setLabel('Login');
        $loginBlock->setComponent('login');
        $loginBlock->addArea(array('nodeId' => NodeInterface::ROOT_NODE_ID, 'areaId' => 'main'));

        $blocksubmenu = new Block();
        $blocksubmenu->setLabel('subMenu');
        $blocksubmenu->setComponent('sub_menu');
        $blocksubmenu->setAttributes(array(
            'class' => 'sousmenu',
            'id' => 'idmenu',
            'nbLevel' => 2,
            'node' => 'fixture_about_us',
        ));
        $blocksubmenu->addArea(array('nodeId' => NodeInterface::ROOT_NODE_ID, 'areaId' => 'main'));

        $blockLanguage = new Block();
        $blockLanguage->setLabel('languages');
        $blockLanguage->setComponent('language_list');
        $blockLanguage->setAttributes(array(
            'class' => 'languageClass',
            'id' => 'languages'
        ));
        $blockLanguage->addArea(array('nodeId' => NodeInterface::ROOT_NODE_ID, 'areaId' => 'main'));

        $homeArea = new Area();
        $homeArea->setLabel('Main');
        $homeArea->setAreaId('main');
        $homeArea->setBlocks(array(
            array('nodeId' => 0, 'blockId' => 0),
            array('nodeId' => 0, 'blockId' => 1),
            array('nodeId' => 0, 'blockId' => 2),
            array('nodeId' => 0, 'blockId' => 3),
        ));

        $home = new Node();
        $home->setNodeId(NodeInterface::ROOT_NODE_ID);
        $home->setNodeType(NodeInterface::TYPE_DEFAULT);
        $home->setSiteId('1');
        $home->setParentId('-');
        $home->setAlias('-');
        $home->setPath('-');
        $home->setName('Fixture Home');
        $home->setVersion($version);
        $home->setLanguage('fr');
        $home->setStatus($this->getReference($status));
        $home->setDeleted(false);
        $home->setTemplateId('template_home');
        $home->setTheme('theme1');
        $home->setInMenu(true);
        $home->setInFooter(false);
        $home->addArea($homeArea);
        $home->addBlock($homeBlock);
        $home->addBlock($loginBlock);
        $home->addBlock($blocksubmenu);
        $home->addBlock($blockLanguage);

        return $home;
    }

    /**
     * @return Node
     */
    protected function generateNodeHomeEn()
    {
        $homeBlock = new Block();
        $homeBlock->setLabel('Home');
        $homeBlock->setComponent('sample');
        $homeBlock->setAttributes(array(
            'title' => 'Welcome',
            'news' => "Welcome to the demo site from fixtures.",
            'author' => ''
        ));
        $homeBlock->addArea(array('nodeId' => NodeInterface::ROOT_NODE_ID, 'areaId' => 'main'));

        $loginBlock = new Block();
        $loginBlock->setLabel('Login');
        $loginBlock->setComponent('login');
        $loginBlock->addArea(array('nodeId' => NodeInterface::ROOT_NODE_ID, 'areaId' => 'main'));

        $homeArea = new Area();
        $homeArea->setLabel('Main');
        $homeArea->setAreaId('main');
        $homeArea->setBlocks(array(
            array('nodeId' => 0, 'blockId' => 0),
            array('nodeId' => 0, 'blockId' => 1),
        ));

        $home = new Node();
        $home->setNodeId(NodeInterface::ROOT_NODE_ID);
        $home->setNodeType(NodeInterface::TYPE_DEFAULT);
        $home->setSiteId('1');
        $home->setParentId('-');
        $home->setAlias('-');
        $home->setPath('-');
        $home->setName('Fixture Home');
        $home->setVersion(1);
        $home->setLanguage('en');
        $home->setStatus($this->getReference('status-published'));
        $home->setDeleted(false);
        $home->setTemplateId('template_home');
        $home->setTheme('theme1');
        $home->setInMenu(true);
        $home->setInFooter(false);
        $home->addArea($homeArea);
        $home->addBlock($homeBlock);
        $home->addBlock($loginBlock);

        return $home;
    }

    /**
     * @return Node
     */
    protected function genereFullFixture()
    {
        $block0 = new Block();
        $block0->setLabel('block 1');
        $block0->setComponent('sample');
        $block0->setAttributes(array(
            'title' => 'Qui sommes-nous?',
            'author' => 'Pourquoi nous choisir ?',
            'news' => 'Nos agences'
        ));
        $block0->addArea(array('nodeId' => 'fixture_full', 'areaId' => 'header'));

        $block1 = new Block();
        $block1->setLabel('block 2');
        $block1->setComponent('menu');
        $block1->setAttributes(array(
            'class' => 'menuclass',
            'id' => 'idmenu',
        ));
        $block1->addArea(array('nodeId' => 'fixture_full', 'areaId' => 'left_menu'));

        $block2 = new Block();
        $block2->setLabel('block 3');
        $block2->setComponent('sample');
        $block2->setAttributes(array(
            "title" => "News 1",
            "author" => "Donec bibendum at nibh eget imperdiet. Mauris eget justo augue. Fusce fermentum iaculis erat, sollicitudin elementum enim sodales eu. Donec a ante tortor. Suspendisse a.",
            "news" => ""
        ));
        $block2->addArea(array('nodeId' => 'fixture_full', 'areaId' => 'content'));

        $block3 = new Block();
        $block3->setLabel('block 4');
        $block3->setComponent('sample');
        $block3->setAttributes(array(
            "title" => "News #2",
            "author" => "Aliquam convallis facilisis nulla, id ultricies ipsum cursus eu. Proin augue quam, iaculis id nisi ac, rutrum blandit leo. In leo ante, scelerisque tempus lacinia in, sollicitudin quis justo. Vestibulum.",
            "news" => ""
        ));
        $block3->addArea(array('nodeId' => 'fixture_full', 'areaId' => 'content'));

        $block4 = new Block();
        $block4->setLabel('block 5');
        $block4->setComponent('sample');
        $block4->setAttributes(array(
            "title" => "News #3",
            "author" => "Phasellus condimentum diam placerat varius iaculis. Aenean dictum, libero in sollicitudin hendrerit, nulla mi elementum massa, eget mattis lorem enim vel magna. Fusce suscipit orci vitae vestibulum.",
            "news" => ""
        ));
        $block4->addArea(array('nodeId' => 'fixture_full', 'areaId' => 'content'));

        $block5 = new Block();
        $block5->setLabel('block 6');
        $block5->setComponent('sample');
        $block5->setAttributes(array(
            'title' => '/apple-touch-icon.png',
            'author' => 'bépo',
            'news' => '',
            'image' => '/apple-touch-icon.png'
        ));
        $block5->addArea(array('nodeId' => 'fixture_full', 'areaId' => 'skycrapper'));

        $block6 = new Block();
        $block6->setLabel('block 7');
        $block6->setComponent('footer');
        $block6->setAttributes(array(
            'id' => 'idFooter',
            'class' => 'footerclass',
        ));
        $block6->addArea(array('nodeId' => 'fixture_full', 'areaId' => 'footer'));

        $block7 = new Block();
        $block7->setLabel('block 8');
        $block7->setComponent('search');
        $block7->setAttributes(array(
            'value' => 'Rechercher',
            'class' => 'classbouton',
            'nodeId' => 'fixture_search',
            'limit' => 8
        ));
        $block7->addArea(array('nodeId' => 'fixture_full', 'areaId' => 'search'));

        $headerArea = new Area();
        $headerArea->setLabel('Header');
        $headerArea->setAreaId('header');
        $headerArea->setBlocks(array(array('nodeId' => 0, 'blockId' => 0)));

        $leftMenuArea = new Area();
        $leftMenuArea->setLabel('Left menu');
        $leftMenuArea->setAreaId('left_menu');
        $leftMenuArea->setBlocks(array(array('nodeId' => 0, 'blockId' => 1)));

        $contentArea = new Area();
        $contentArea->setLabel('Content');
        $contentArea->setAreaId('content');
        $contentArea->setBlocks(array(
            array('nodeId' => 0, 'blockId' => 2),
            array('nodeId' => 0, 'blockId' => 3),
            array('nodeId' => 0, 'blockId' => 4),
        ));

        $skycrapperArea = new Area();
        $skycrapperArea->setLabel('Skycrapper');
        $skycrapperArea->setAreaId('skycrapper');
        $skycrapperArea->setBlocks(array(array('nodeId' => 0, 'blockId' => 5)));

        $mainArea = new Area();
        $mainArea->setLabel('Main');
        $mainArea->setAreaId('main');
        $mainArea->setBoDirection('v');
        $mainArea->addArea($leftMenuArea);
        $mainArea->addArea($contentArea);
        $mainArea->addArea($skycrapperArea);

        $footerArea = new Area();
        $footerArea->setLabel('Footer');
        $footerArea->setAreaId('footer');
        $footerArea->setBlocks(array(array('nodeId' => 0, 'blockId' => 6)));

        $searchArea = new Area();
        $searchArea->setLabel('Search');
        $searchArea->setAreaId('Search');
        $searchArea->setBlocks(array(array('nodeId' => 0, 'blockId' => 7)));

        $full = new Node();
        $full->setNodeId('fixture_full');
        $full->setNodeType(NodeInterface::TYPE_DEFAULT);
        $full->setSiteId('1');
        $full->setParentId(NodeInterface::ROOT_NODE_ID);
        $full->setPath('-');
        $full->setAlias('fixture-full');
        $full->setName('Fixture full sample');
        $full->setVersion(1);
        $full->setLanguage('fr');
        $full->setStatus($this->getReference('status-published'));
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
        $full->setRole('ROLE_ADMIN');

        return $full;
    }

    /**
     * @return Node
     */
    protected function generateGenericNode()
    {
        $genericArea = new Area();
        $genericArea->setLabel('Generic Area');
        $genericArea->setAreaId('Generic Area');

        $generic = new Node();
        $generic->setNodeId('fixutre_generic');
        $generic->setNodeType(NodeInterface::TYPE_DEFAULT);
        $generic->setSiteId('1');
        $generic->setParentId(NodeInterface::ROOT_NODE_ID);
        $generic->setPath('-');
        $generic->setAlias('fixture-generic');
        $generic->setName('Generic Node');
        $generic->setVersion(1);
        $generic->setLanguage('fr');
        $generic->setStatus($this->getReference('status-published'));
        $generic->setTemplateId('template_generic');
        $generic->setDeleted(true);
        $generic->setInMenu(false);
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
        $aboutUsBlock->setLabel('About us');
        $aboutUsBlock->setComponent('sample');
        $aboutUsBlock->setAttributes(array(
            'title' => 'Qui sommes-nous?',
            'author' => 'Pour tout savoir sur notre entreprise.',
            'news' => ''
        ));
        $aboutUsBlock->addArea(array('nodeId' => 'fixture_about_us', 'areaId' => 'main'));

        $contentListBlock = new Block();
        $contentListBlock->setLabel('Content list');
        $contentListBlock->setComponent('content_list');
        $contentListBlock->setAttributes(array(
            'contentType' => 'news',
            'id' => 'contentNewsList',
            'class' => 'contentListClass',
            'url' => 'fixture_bd'
        ));
        $contentListBlock->addArea(array('nodeId' => 'fixture_about_us', 'areaId' => 'main'));

        $aboutUsArea = new Area();
        $aboutUsArea->setLabel('Main');
        $aboutUsArea->setAreaId('main');
        $aboutUsArea->addBlock(array('nodeId' => 0, 'blockId' => 0));
        $aboutUsArea->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $aboutUs = new Node();
        $aboutUs->setNodeId('fixture_about_us');
        $aboutUs->setNodeType(NodeInterface::TYPE_DEFAULT);
        $aboutUs->setName('Fixture About Us');
        $aboutUs->setSiteId('1');
        $aboutUs->setParentId(NodeInterface::ROOT_NODE_ID);
        $aboutUs->setPath('-');
        $aboutUs->setAlias('qui-sommes-nous');
        $aboutUs->setVersion(1);
        $aboutUs->setLanguage('fr');
        $aboutUs->setStatus($this->getReference('status-published'));
        $aboutUs->setDeleted(false);
        $aboutUs->setTemplateId('template_home');
        $aboutUs->setTheme('theme2');
        $aboutUs->setInFooter(true);
        $aboutUs->setInMenu(true);
        $aboutUs->addArea($aboutUsArea);
        $aboutUs->addBlock($aboutUsBlock);
        $aboutUs->addBlock($contentListBlock);

        return $aboutUs;
    }

    /**
     * @return Node
     */
    protected function generateBdNode()
    {
        $bdBlock = new Block();
        $bdBlock->setLabel('B&D');
        $bdBlock->setComponent('sample');
        $bdBlock->setAttributes(array(
            'title' => 'B&D',
            'author' => 'Tout sur B&D',
            'news' => ''
        ));
        $bdBlock->addArea(array('nodeId' => 'fixture_bd', 'areaId' => 'main'));

        $contentBlock = new Block();
        $contentBlock->setLabel('content news');
        $contentBlock->setComponent('content_list');
        $contentBlock->setAttributes(array(
            'contentType' => 'news',
            'id' => 'contentNewsList',
            'class' => 'contentListClass',
            'url' => 'fixture_bd'
        ));
        $contentBlock->addArea(array('nodeId' => 'fixture_bd', 'areaId' => 'main'));

        $bdArea = new Area();
        $bdArea->setLabel('Main');
        $bdArea->setAreaId('main');
        $bdArea->addBlock(array('nodeId' => 0, 'blockId' => 0));
        $bdArea->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $bd = new Node();
        $bd->setNodeId('fixture_bd');
        $bd->setNodeType(NodeInterface::TYPE_DEFAULT);
        $bd->setName('Fixture B&D');
        $bd->setSiteId('1');
        $bd->setParentId('fixture_about_us');
        $bd->setPath('-');
        $bd->setAlias('b-et-d');
        $bd->setVersion(1);
        $bd->setLanguage('fr');
        $bd->setStatus($this->getReference('status-published'));
        $bd->setDeleted(false);
        $bd->setTemplateId('template_home');
        $bd->setTheme('theme2');
        $bd->setInFooter(true);
        $bd->setInMenu(true);
        $bd->addArea($bdArea);
        $bd->addBlock($bdBlock);
        $bd->addBlock($contentBlock);

        return $bd;
    }

    /**
     * @return Node
     */
    protected function generateInteraktingNode()
    {
        $interaktingBlock = new Block();
        $interaktingBlock->setLabel('Interakting');
        $interaktingBlock->setComponent('sample');
        $interaktingBlock->setAttributes(array(
            'title' => 'Interakting',
            'author' => '',
            'news' => 'Des trucs sur Interakting (non versionnés)'
        ));
        $interaktingBlock->addArea(array('nodeId' => 'fixture_interakting', 'areaId' => 'main'));

        $interaktingArea = new Area();
        $interaktingArea->setLabel('Main');
        $interaktingArea->setAreaId('main');
        $interaktingArea->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $interakting = new Node();
        $interakting->setNodeId('fixture_interakting');
        $interakting->setNodeType(NodeInterface::TYPE_DEFAULT);
        $interakting->setName('Fixture Interakting');
        $interakting->setSiteId('1');
        $interakting->setParentId('fixture_about_us');
        $interakting->setPath('-');
        $interakting->setAlias('interakting');
        $interakting->setVersion(1);
        $interakting->setLanguage('fr');
        $interakting->setStatus($this->getReference('status-published'));
        $interakting->setDeleted(false);
        $interakting->setTemplateId('template_home');
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
        $contactUsBlock->setLabel('Contact Us');
        $contactUsBlock->setComponent('sample');
        $contactUsBlock->setAttributes(array(
            'title' => 'Nous contacter',
            'author' => 'Comment nous contacter',
            'news' => 'swgsdwgh',
            'contentType' => 'news'
        ));
        $contactUsBlock->addArea(array('nodeId' => 'fixture_contact_us', 'areaId' => 'main'));

        $contactUsArea = new Area();
        $contactUsArea->setLabel('Main');
        $contactUsArea->setAreaId('main');
        $contactUsArea->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $contactUs = new Node();
        $contactUs->setNodeId('fixture_contact_us');
        $contactUs->setNodeType(NodeInterface::TYPE_DEFAULT);
        $contactUs->setName('Fixture Contact Us');
        $contactUs->setSiteId('1');
        $contactUs->setParentId(NodeInterface::ROOT_NODE_ID);
        $contactUs->setPath('-');
        $contactUs->setAlias('nous-contacter');
        $contactUs->setVersion(1);
        $contactUs->setLanguage('fr');
        $contactUs->setStatus($this->getReference('status-published'));
        $contactUs->setDeleted(false);
        $contactUs->setTemplateId('template_home');
        $contactUs->setTheme('theme1');
        $contactUs->setInFooter(true);
        $contactUs->setInMenu(true);
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
        $directoryBlock->setLabel('Directory');
        $directoryBlock->setComponent('sample');
        $directoryBlock->setAttributes(array(
            'title' => 'Annuaire',
            'author' => 'Le bottin mondain',
            'news' => '',
            'contentType' => 'car'
        ));
        $directoryBlock->addArea(array('nodeId' => 'fixture_search', 'areaId' => 'main'));

        $directoryArea = new Area();
        $directoryArea->setLabel('Main');
        $directoryArea->setAreaId('main');
        $directoryArea->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $directory = new Node();
        $directory->setNodeId('fixture_directory');
        $directory->setNodeType(NodeInterface::TYPE_DEFAULT);
        $directory->setName('Fixture Directory');
        $directory->setSiteId('1');
        $directory->setParentId(NodeInterface::ROOT_NODE_ID);
        $directory->setPath('-');
        $directory->setAlias('nous-contacter');
        $directory->setVersion(1);
        $directory->setLanguage('fr');
        $directory->setStatus($this->getReference('status-published'));
        $directory->setDeleted(false);
        $directory->setTemplateId('template_home');
        $directory->setTheme('fromApp');
        $directory->setInFooter(true);
        $directory->setInMenu(true);
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
        $searchBlock0->setLabel('Search block');
        $searchBlock0->setComponent('sample');
        $searchBlock0->setAttributes(array(
            'title' => 'Qui somme-nous?',
            'author' => 'Pourquoi nous choisir ?',
            'news' => 'Nos agences'
        ));
        $searchBlock0->addArea(array('nodeId' => 'fixture_search', 'areaId' => 'header'));

        $searchBlock1 = new Block();
        $searchBlock1->setLabel('Menu');
        $searchBlock1->setComponent('menu');
        $searchBlock1->setAttributes(array(
            'class' => 'menuClass',
            'id' => 'idmenu',
        ));
        $searchBlock1->addArea(array('nodeId' => 'fixture_search', 'areaId' => 'left_menu'));

        $searchBlock2 = new Block();
        $searchBlock2->setLabel('search');
        $searchBlock2->setComponent('search');
        $searchBlock2->setAttributes(array(
            'value' => 'Rechercher',
            'name' => "btnSearch",
            'class' => 'classbouton',
            'nodeId' => 'fixture_search'
        ));
        $searchBlock2->addArea(array('nodeId' => 'fixture_search', 'areaId' => 'content'));

        $searchBlock3 = new Block();
        $searchBlock3->setLabel('Search result');
        $searchBlock3->setComponent('search_result');
        $searchBlock3->setAttributes(array(
            'nodeId' => 'fixture_search',
            'nbdoc' => '5',
            'fielddisplayed' => array(
                "title_s", "news_t", "author_ss", "title_txt", "intro_t", "text_t", "description_t", "image_img"
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
        $searchBlock3->addArea(array('nodeId' => 'fixture_search', 'areaId' => 'content'));

        $searchBlock4 = new Block();
        $searchBlock4->setLabel('Footer');
        $searchBlock4->setComponent('footer');
        $searchBlock4->setAttributes(array(
            'id' => 'idFooter',
            'class' => 'footerClass',
        ));
        $searchBlock4->addArea(array('nodeId' => 'fixture_search', 'areaId' => 'footer'));

        $searchArea0 = new Area();
        $searchArea0->setLabel('Header');
        $searchArea0->setAreaId('header');
        $searchArea0->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $leftMenuArea = new Area();
        $leftMenuArea->setLabel('Left menu');
        $leftMenuArea->setAreaId('left_menu');
        $leftMenuArea->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $contentArea = new Area();
        $contentArea->setLabel('Content');
        $contentArea->setAreaId('content');
        $contentArea->addBlock(array('nodeId' => 0, 'blockId' => 2));
        $contentArea->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $searchArea1 = new Area();
        $searchArea1->setLabel('Main');
        $searchArea1->setAreaId('main');
        $searchArea1->setBoDirection('v');
        $searchArea1->addArea($leftMenuArea);
        $searchArea1->addArea($contentArea);


        $searchArea2 = new Area();
        $searchArea2->setLabel('Footer');
        $searchArea2->setAreaId('footer');
        $searchArea2->addBlock(array('nodeId' => 0, 'blockId' => 4));

        $search = new Node();
        $search->setNodeId('fixture_search');
        $search->setNodeType(NodeInterface::TYPE_DEFAULT);
        $search->setName('Fixture Search');
        $search->setSiteId('1');
        $search->setParentId(NodeInterface::ROOT_NODE_ID);
        $search->setPath('-');
        $search->setAlias('nous-contacter');
        $search->setVersion(1);
        $search->setLanguage('fr');
        $search->setStatus($this->getReference('status-published'));
        $search->setDeleted(false);
        $search->setTemplateId('template_home');
        $search->setTheme('fromApp');
        $search->setInFooter(true);
        $search->setInMenu(true);
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
