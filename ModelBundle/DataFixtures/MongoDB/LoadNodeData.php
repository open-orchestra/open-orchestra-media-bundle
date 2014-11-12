<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Area;
use PHPOrchestra\ModelBundle\Document\Block;
use PHPOrchestra\ModelBundle\Document\Node;

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
        $home = $this->generateNodeHome();
        $manager->persist($home);

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

        $siteHome = $this->generateNodeSiteHome();
        $manager->persist($siteHome);

        $siteWhat = $this->generateNodeSiteWhatIsOrchestra();
        $manager->persist($siteWhat);

        $siteAboutUs = $this->generateNodeSiteAboutUs();
        $manager->persist($siteAboutUs);

        $siteCommunity = $this->generateNodeSiteCommunity();
        $manager->persist($siteCommunity);

        $siteContact = $this->generateNodeSiteContact();
        $manager->persist($siteContact);

        $siteDocumentation = $this->generateNodeSiteDocumentation();
        $manager->persist($siteDocumentation);

        $siteJoinUs = $this->generateNodeSiteJoinUs();
        $manager->persist($siteJoinUs);

        $siteLegalMention = $this->generateNodeSiteLegalMentions();
        $manager->persist($siteLegalMention);

        $siteNetwork = $this->generateNodeSiteNetwork();
        $manager->persist($siteNetwork);

        $siteNews = $this->generateNodeSiteNews();
        $manager->persist($siteNews);

        $siteOurTeam = $this->generateNodeSiteOurTeam();
        $manager->persist($siteOurTeam);

        $siteStart = $this->generateNodeSiteStartOrchestra();
        $manager->persist($siteStart);

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
    protected function generateNodeHome()
    {
        $homeBlock = new Block();
        $homeBlock->setLabel('Home');
        $homeBlock->setComponent('sample');
        $homeBlock->setAttributes(array(
            'title' => 'Accueil',
            'news' => "Bienvenu sur le site de démo issu des fixtures.",
            'author' => ''
        ));
        $homeBlock->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $loginBlock = new Block();
        $loginBlock->setLabel('Login');
        $loginBlock->setComponent('login');
        $loginBlock->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $blocksubmenu = new Block();
        $blocksubmenu->setLabel('subMenu');
        $blocksubmenu->setComponent('sub_menu');
        $blocksubmenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'idmenu',
            'nbLevel' => 2,
            'node' => 'fixture_about_us',
        ));
        $blocksubmenu->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $blockLanguage = new Block();
        $blockLanguage->setLabel('languages');
        $blockLanguage->getComponent('language_list');
        $blockLanguage->setAttributes(array(
            'languages' => array('fr', 'en'),
            'default' => 'fr'
        ));
        $blockLanguage->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $homeArea = new Area();
        $homeArea->setLabel('Main');
        $homeArea->setAreaId('main');
        $homeArea->setBlocks(array(
            array('nodeId' => 0, 'blockId' => 0),
            array('nodeId' => 0, 'blockId' => 1),
            array('nodeId' => 0, 'blockId' => 2),
        ));

        $home = new Node();
        $home->setNodeId('root');
        $home->setNodeType('page');
        $home->setSiteId('1');
        $home->setParentId('-');
        $home->setAlias('-');
        $home->setPath('-');
        $home->setName('Fixture Home');
        $home->setVersion(1);
        $home->setLanguage('fr');
        $home->setStatus($this->getReference('status-published'));
        $home->setDeleted(false);
        $home->setTemplateId('template_main');
        $home->setTheme('theme1');
        $home->setInMenu(true);
        $home->setInFooter(false);
        $home->addArea($homeArea);
        $home->addBlock($homeBlock);
        $home->addBlock($loginBlock);
        $home->addBlock($blockLanguage);
        $home->addBlock($blocksubmenu);

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
            'title' => 'Accueil',
            'news' => "Bienvenu sur le site de démo issu des fixtures.",
            'author' => ''
        ));
        $homeBlock->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $loginBlock = new Block();
        $loginBlock->setLabel('Login');
        $loginBlock->setComponent('login');
        $loginBlock->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $blocksubmenu = new Block();
        $blocksubmenu->setLabel('subMenu');
        $blocksubmenu->setComponent('sub_menu');
        $blocksubmenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'idmenu',
            'nbLevel' => 2,
            'node' => 'fixture_about_us',
        ));
        $blocksubmenu->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $homeArea = new Area();
        $homeArea->setLabel('Main');
        $homeArea->setAreaId('main');
        $homeArea->setBlocks(array(
            array('nodeId' => 0, 'blockId' => 0),
            array('nodeId' => 0, 'blockId' => 1),
            array('nodeId' => 0, 'blockId' => 2),
        ));

        $home = new Node();
        $home->setNodeId('root');
        $home->setNodeType('page');
        $home->setSiteId('1');
        $home->setParentId('-');
        $home->setAlias('-');
        $home->setPath('-');
        $home->setName('Fixture Home');
        $home->setVersion(1);
        $home->setLanguage('en');
        $home->setStatus($this->getReference('status-published'));
        $home->setDeleted(false);
        $home->setTemplateId('template_main');
        $home->setTheme('theme1');
        $home->setInMenu(true);
        $home->setInFooter(false);
        $home->addArea($homeArea);
        $home->addBlock($homeBlock);
        $home->addBlock($loginBlock);
        $home->addBlock($blocksubmenu);

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
        $block0->addArea(array('nodeId' => 0, 'areaId' => 'header'));

        $block1 = new Block();
        $block1->setLabel('block 2');
        $block1->setComponent('menu');
        $block1->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'idmenu',
        ));
        $block1->addArea(array('nodeId' => 0, 'areaId' => 'left_menu'));

        $block2 = new Block();
        $block2->setLabel('block 3');
        $block2->setComponent('sample');
        $block2->setAttributes(array(
            "title" => "News 1",
            "author" => "Donec bibendum at nibh eget imperdiet. Mauris eget justo augue. Fusce fermentum iaculis erat, sollicitudin elementum enim sodales eu. Donec a ante tortor. Suspendisse a.",
            "news" => ""
        ));
        $block2->addArea(array('nodeId' => 0, 'areaId' => 'content'));

        $block3 = new Block();
        $block3->setLabel('block 4');
        $block3->setComponent('sample');
        $block3->setAttributes(array(
            "title" => "News #2",
            "author" => "Aliquam convallis facilisis nulla, id ultricies ipsum cursus eu. Proin augue quam, iaculis id nisi ac, rutrum blandit leo. In leo ante, scelerisque tempus lacinia in, sollicitudin quis justo. Vestibulum.",
            "news" => ""
        ));
        $block3->addArea(array('nodeId' => 0, 'areaId' => 'content'));

        $block4 = new Block();
        $block4->setLabel('block 5');
        $block4->setComponent('sample');
        $block4->setAttributes(array(
            "title" => "News #3",
            "author" => "Phasellus condimentum diam placerat varius iaculis. Aenean dictum, libero in sollicitudin hendrerit, nulla mi elementum massa, eget mattis lorem enim vel magna. Fusce suscipit orci vitae vestibulum.",
            "news" => ""
        ));
        $block4->addArea(array('nodeId' => 0, 'areaId' => 'content'));

        $block5 = new Block();
        $block5->setLabel('block 6');
        $block5->setComponent('sample');
        $block5->setAttributes(array(
            'title' => '/apple-touch-icon.png',
            'author' => 'bépo',
            'news' => '',
            'image' => '/apple-touch-icon.png'
        ));
        $block5->addArea(array('nodeId' => 0, 'areaId' => 'skycrapper'));

        $block6 = new Block();
        $block6->setLabel('block 7');
        $block6->setComponent('footer');
        $block6->setAttributes(array(
            'id' => 'idFooter',
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
        ));
        $block6->addArea(array('nodeId' => 0, 'areaId' => 'footer'));

        $block7 = new Block();
        $block7->setLabel('block 8');
        $block7->setComponent('search');
        $block7->setAttributes(array(
            'value' => 'Rechercher',
            'class' => 'classbouton',
            'nodeId' => 'fixture_search',
            'limit' => 8
        ));
        $block7->addArea(array('nodeId' => 0, 'areaId' => 'search'));

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
        $full->setNodeType('page');
        $full->setSiteId('1');
        $full->setParentId('root');
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
        $generic->setNodeType('page');
        $generic->setSiteId('1');
        $generic->setParentId('root');
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
        $aboutUsBlock->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $contentListBlock = new Block();
        $contentListBlock->setLabel('Content list');
        $contentListBlock->setComponent('content_list');
        $contentListBlock->setAttributes(array(
            'contentType' => 'news',
            'id' => 'contentNewsList',
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'title' => 'titleclass'
            ),
            'url' => 'fixture_bd'
        ));
        $contentListBlock->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $aboutUsArea = new Area();
        $aboutUsArea->setLabel('Main');
        $aboutUsArea->setAreaId('main');
        $aboutUsArea->addBlock(array('nodeId' => 0, 'blockId' => 0));
        $aboutUsArea->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $aboutUs = new Node();
        $aboutUs->setNodeId('fixture_about_us');
        $aboutUs->setNodeType('page');
        $aboutUs->setName('Fixture About Us');
        $aboutUs->setSiteId('1');
        $aboutUs->setParentId('root');
        $aboutUs->setPath('-');
        $aboutUs->setAlias('qui-sommes-nous');
        $aboutUs->setVersion(1);
        $aboutUs->setLanguage('fr');
        $aboutUs->setStatus($this->getReference('status-published'));
        $aboutUs->setDeleted(false);
        $aboutUs->setTemplateId('template_main');
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
        $bdBlock->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $contentBlock = new Block();
        $contentBlock->setLabel('content news');
        $contentBlock->setComponent('content');
        $contentBlock->setAttributes(array(
            'id' => 'contentNews',
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'title' => 'titleclass',
                'content' => 'contentclass'
            ),
        ));
        $contentBlock->addArea(array('nodeId' => 1, 'areaId' => 'main'));

        $bdArea = new Area();
        $bdArea->setLabel('Main');
        $bdArea->setAreaId('main');
        $bdArea->addBlock(array('nodeId' => 0, 'blockId' => 0));
        $bdArea->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $bd = new Node();
        $bd->setNodeId('fixture_bd');
        $bd->setNodeType('page');
        $bd->setName('Fixture B&D');
        $bd->setSiteId('1');
        $bd->setParentId('fixture_about_us');
        $bd->setPath('-');
        $bd->setAlias('b-et-d');
        $bd->setVersion(1);
        $bd->setLanguage('fr');
        $bd->setStatus($this->getReference('status-published'));
        $bd->setDeleted(false);
        $bd->setTemplateId('template_main');
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
        $interaktingBlock->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $interaktingArea = new Area();
        $interaktingArea->setLabel('Main');
        $interaktingArea->setAreaId('main');
        $interaktingArea->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $interakting = new Node();
        $interakting->setNodeId('fixture_interakting');
        $interakting->setNodeType('page');
        $interakting->setName('Fixture Interakting');
        $interakting->setSiteId('1');
        $interakting->setParentId('fixture_about_us');
        $interakting->setPath('-');
        $interakting->setAlias('interakting');
        $interakting->setVersion(1);
        $interakting->setLanguage('fr');
        $interakting->setStatus($this->getReference('status-published'));
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
        $contactUsBlock->setLabel('Contact Us');
        $contactUsBlock->setComponent('sample');
        $contactUsBlock->setAttributes(array(
            'title' => 'Nous contacter',
            'author' => 'Comment nous contacter',
            'news' => 'swgsdwgh',
            'contentType' => 'news'
        ));
        $contactUsBlock->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $contactUsArea = new Area();
        $contactUsArea->setLabel('Main');
        $contactUsArea->setAreaId('main');
        $contactUsArea->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $contactUs = new Node();
        $contactUs->setNodeId('fixture_contact_us');
        $contactUs->setNodeType('page');
        $contactUs->setName('Fixture Contact Us');
        $contactUs->setSiteId('1');
        $contactUs->setParentId('root');
        $contactUs->setPath('-');
        $contactUs->setAlias('nous-contacter');
        $contactUs->setVersion(1);
        $contactUs->setLanguage('fr');
        $contactUs->setStatus($this->getReference('status-published'));
        $contactUs->setDeleted(false);
        $contactUs->setTemplateId('template_main');
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
        $directoryBlock->addArea(array('nodeId' => 0, 'areaId' => 'main'));

        $directoryArea = new Area();
        $directoryArea->setLabel('Main');
        $directoryArea->setAreaId('main');
        $directoryArea->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $directory = new Node();
        $directory->setNodeId('fixture_directory');
        $directory->setNodeType('directory');
        $directory->setName('Fixture Directory');
        $directory->setSiteId('1');
        $directory->setParentId('root');
        $directory->setPath('-');
        $directory->setAlias('nous-contacter');
        $directory->setVersion(1);
        $directory->setLanguage('fr');
        $directory->setStatus($this->getReference('status-published'));
        $directory->setDeleted(false);
        $directory->setTemplateId('template_main');
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
        $searchBlock0->addArea(array('nodeId' => 0, 'areaId' => 'header'));

        $searchBlock1 = new Block();
        $searchBlock1->setLabel('Menu');
        $searchBlock1->setComponent('menu');
        $searchBlock1->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'idmenu',
        ));
        $searchBlock1->addArea(array('nodeId' => 0, 'areaId' => 'left_menu'));

        $searchBlock2 = new Block();
        $searchBlock2->setLabel('search');
        $searchBlock2->setComponent('search');
        $searchBlock2->setAttributes(array(
            'value' => 'Rechercher',
            'name' => "btnSearch",
            'class' => 'classbouton',
            'nodeId' => 'fixture_search'
        ));
        $searchBlock2->addArea(array('nodeId' => 0, 'areaId' => 'content'));

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
        $searchBlock3->addArea(array('nodeId' => 0, 'areaId' => 'content'));

        $searchBlock4 = new Block();
        $searchBlock4->setLabel('Footer');
        $searchBlock4->setComponent('footer');
        $searchBlock4->setAttributes(array(
            'id' => 'idFooter',
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
        ));
        $searchBlock4->addArea(array('nodeId' => 0, 'areaId' => 'footer'));

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
        $search->setNodeType('search');
        $search->setName('Fixture Search');
        $search->setSiteId('1');
        $search->setParentId('root');
        $search->setPath('-');
        $search->setAlias('nous-contacter');
        $search->setVersion(1);
        $search->setLanguage('fr');
        $search->setStatus($this->getReference('status-published'));
        $search->setDeleted(false);
        $search->setTemplateId('template_main');
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

    /**
     * @return Node
     */
    public function generateNodeSiteHome()
    {
        $siteHomeBlock0 = new Block();
        $siteHomeBlock0->setLabel('Wysiwyg 1');
        $siteHomeBlock0->setComponent('tiny_mce_wysiwyg');
        $siteHomeBlock0->setAttributes(array(
            "htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themePresentation/img/logoOrchestra.png' /> </a>",
        ));
        $siteHomeBlock0->addArea(array('nodeId' => 0, 'areaId' => 'logo'));
        $siteHomeBlock0->addArea(array('nodeId' => 'fixture_page_what_is_orchestra', 'areaId' => 'logo'));
        $siteHomeBlock0->addArea(array('nodeId' => 'fixture_page_start_orchestra', 'areaId' => 'logo'));
        $siteHomeBlock0->addArea(array('nodeId' => 'fixture_page_documentation', 'areaId' => 'logo'));
        $siteHomeBlock0->addArea(array('nodeId' => 'fixture_page_community', 'areaId' => 'logo'));
        $siteHomeBlock0->addArea(array('nodeId' => 'fixture_page_about_us', 'areaId' => 'logo'));
        $siteHomeBlock0->addArea(array('nodeId' => 'fixture_page_our_team', 'areaId' => 'logo'));
        $siteHomeBlock0->addArea(array('nodeId' => 'fixture_page_news', 'areaId' => 'logo'));
        $siteHomeBlock0->addArea(array('nodeId' => 'fixture_page_join_us', 'areaId' => 'logo'));
        $siteHomeBlock0->addArea(array('nodeId' => 'fixture_page_networks', 'areaId' => 'logo'));
        $siteHomeBlock0->addArea(array('nodeId' => 'fixture_page_contact', 'areaId' => 'logo'));
        $siteHomeBlock0->addArea(array('nodeId' => 'fixture_page_legal_mentions', 'areaId' => 'logo'));

        $siteHomeBlock1 = new Block();
        $siteHomeBlock1->setLabel('Wysiwyg 2');
        $siteHomeBlock1->setComponent('tiny_mce_wysiwyg');
        $siteHomeBlock1->setAttributes(array(
            "htmlContent" => "<ul id='mySubMenu'> <li><a href='/page-home/page-about-us'> A PROPOS </a></li> <li><a href='/page-home/page-our-team'> NOTRE EQUIPE </a></li><li><a href='/page-home/page-our-news'> NOTRE ACTU </a></li><li><a href='/page-home/page-nous-rejoindre'>  NOUS REJOINDRE</a></li> <li><a href='/page-home/page-networks'> NETWORKS </a></li> </ul>",
        ));
        $siteHomeBlock1->addArea(array('nodeId' => 0, 'areaId' => 'sub_menu'));
        $siteHomeBlock1->addArea(array('nodeId' => 'fixture_page_what_is_orchestra', 'areaId' => 'sub_menu'));
        $siteHomeBlock1->addArea(array('nodeId' => 'fixture_page_start_orchestra', 'areaId' => 'sub_menu'));
        $siteHomeBlock1->addArea(array('nodeId' => 'fixture_page_documentation', 'areaId' => 'sub_menu'));
        $siteHomeBlock1->addArea(array('nodeId' => 'fixture_page_community', 'areaId' => 'sub_menu'));
        $siteHomeBlock1->addArea(array('nodeId' => 'fixture_page_about_us', 'areaId' => 'sub_menu'));
        $siteHomeBlock1->addArea(array('nodeId' => 'fixture_page_our_team', 'areaId' => 'sub_menu'));
        $siteHomeBlock1->addArea(array('nodeId' => 'fixture_page_news', 'areaId' => 'sub_menu'));
        $siteHomeBlock1->addArea(array('nodeId' => 'fixture_page_join_us', 'areaId' => 'sub_menu'));
        $siteHomeBlock1->addArea(array('nodeId' => 'fixture_page_networks', 'areaId' => 'sub_menu'));
        $siteHomeBlock1->addArea(array('nodeId' => 'fixture_page_contact', 'areaId' => 'sub_menu'));
        $siteHomeBlock1->addArea(array('nodeId' => 'fixture_page_legal_mentions', 'areaId' => 'sub_menu'));

        $siteHomeBlockMenu = new Block();
        $siteHomeBlockMenu->setLabel('Menu');
        $siteHomeBlockMenu->setComponent('menu');
        $siteHomeBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));
        $siteHomeBlockMenu->addArea(array('nodeId' => 0, 'areaId' => 'main_menu'));
        $siteHomeBlockMenu->addArea(array('nodeId' => 'fixture_page_what_is_orchestra', 'areaId' => 'main_menu'));
        $siteHomeBlockMenu->addArea(array('nodeId' => 'fixture_page_start_orchestra', 'areaId' => 'main_menu'));
        $siteHomeBlockMenu->addArea(array('nodeId' => 'fixture_page_documentation', 'areaId' => 'main_menu'));
        $siteHomeBlockMenu->addArea(array('nodeId' => 'fixture_page_community', 'areaId' => 'main_menu'));
        $siteHomeBlockMenu->addArea(array('nodeId' => 'fixture_page_about_us', 'areaId' => 'main_menu'));
        $siteHomeBlockMenu->addArea(array('nodeId' => 'fixture_page_our_team', 'areaId' => 'main_menu'));
        $siteHomeBlockMenu->addArea(array('nodeId' => 'fixture_page_news', 'areaId' => 'main_menu'));
        $siteHomeBlockMenu->addArea(array('nodeId' => 'fixture_page_join_us', 'areaId' => 'main_menu'));
        $siteHomeBlockMenu->addArea(array('nodeId' => 'fixture_page_networks', 'areaId' => 'main_menu'));
        $siteHomeBlockMenu->addArea(array('nodeId' => 'fixture_page_contact', 'areaId' => 'main_menu'));
        $siteHomeBlockMenu->addArea(array('nodeId' => 'fixture_page_legal_mentions', 'areaId' => 'main_menu'));

        $siteHomeCarrousel = new Block();
        $siteHomeCarrousel->setLabel('Carrousel');
        $siteHomeCarrousel->setComponent('carrousel');
        $siteHomeCarrousel->setAttributes(array(
            'pictures' => array(
                array('src' => "/bundles/fakeapptheme/themes/themePresentation/img/carroussel/02.jpg"),
                array('src' => "/bundles/fakeapptheme/themes/themePresentation/img/carroussel/03.jpg"),
                array('src' => "/bundles/fakeapptheme/themes/themePresentation/img/carroussel/04.jpg"),
                array('src' => "/bundles/fakeapptheme/themes/themePresentation/img/carroussel/05.jpg"),
            ),
            'width' => "600px",
            'height' => "300px",
            "carrousel_id" => 'slider1_container',
        ));
        $siteHomeCarrousel->addArea(array('nodeId' => 0, 'areaId' => 'mainContentCarrousel'));

        $siteHomeBlock4 = new Block();
        $siteHomeBlock4->setLabel('Wysiwyg 1');
        $siteHomeBlock4->setComponent('tiny_mce_wysiwyg');
        $siteHomeBlock4->setAttributes(array(
            "htmlContent" => "<div id='area2.2' class='content'><p>
            Business & Decision est un Groupe international de services numériques,  leader de la Business Intelligence (BI) et du CRM, acteur majeur de l'e-Business.  Le Groupe contribue à la réussite des projets à forte valeur ajoutée des entreprises et accompagne ses clients dans des domaines d’innovation tels que le Big Data et le Digital. Il est reconnu pour son expertise fonctionnelle et technologique par les plus grands éditeurs de logiciels du marché avec lesquels il a noué des partenariats. Fort d’une expertise unique dans ses domaines de spécialisation, Business & Decision offre des solutions adaptées à des secteurs d’activité ainsi qu’à des directions métiers.
            </p></div>",
        ));
        $siteHomeBlock4->addArea(array('nodeId' => 0, 'areaId' => 'mainContentArea2'));

        $siteHomeBlock5 = new Block();
        $siteHomeBlock5->setLabel('Wysiwyg 2');
        $siteHomeBlock5->setComponent('tiny_mce_wysiwyg');
        $siteHomeBlock5->setAttributes(array(
            "htmlContent" => "<div id='footerInfos'><h4>Infos</h4><ul><li> <a href='/app_dev.php/node/fixture_page_about_us'>Qui sommes nous ?</a> </li><li> <a href='/app_dev.php/node/fixture_page_contact'>Contact</a> </li></ul></div> <div id='footerLegal'><h4>Légal</h4><ul><li> <a href=''>Mentions Légal</a> </li><li> <a href='/app_dev.php/node/fixture_page_networks'>Plan du site</a> </li></ul></div> <div id='footerNetworks'><h4>Networks</h4><ul><li> <a href='http://www.businessdecision.fr/'>http://www.businessdecision.fr/</a> </li><li> <a href='http://www.interakting.com/'>http://www.interakting.com/</a> </li></ul></div> <div id='footerContact'><h4>Contact</h4> <ul> <li>Interakting</li><li>153 Rue de Courcelles</li> <li>75017 Paris France</li> <li>01 56 21 21 21</li><li> <a href='/app_dev.php/node/fixture_page_contact'>contact@interakting.com </a> </li></div>",
        ));
        $siteHomeBlock5->addArea(array('nodeId' => 0, 'areaId' => 'footer'));
        $siteHomeBlock5->addArea(array('nodeId' => 'fixture_page_what_is_orchestra', 'areaId' => 'footer'));
        $siteHomeBlock5->addArea(array('nodeId' => 'fixture_page_start_orchestra', 'areaId' => 'footer'));
        $siteHomeBlock5->addArea(array('nodeId' => 'fixture_page_documentation', 'areaId' => 'footer'));
        $siteHomeBlock5->addArea(array('nodeId' => 'fixture_page_community', 'areaId' => 'footer'));
        $siteHomeBlock5->addArea(array('nodeId' => 'fixture_page_about_us', 'areaId' => 'footer'));
        $siteHomeBlock5->addArea(array('nodeId' => 'fixture_page_our_team', 'areaId' => 'footer'));
        $siteHomeBlock5->addArea(array('nodeId' => 'fixture_page_news', 'areaId' => 'footer'));
        $siteHomeBlock5->addArea(array('nodeId' => 'fixture_page_join_us', 'areaId' => 'footer'));
        $siteHomeBlock5->addArea(array('nodeId' => 'fixture_page_networks', 'areaId' => 'footer'));
        $siteHomeBlock5->addArea(array('nodeId' => 'fixture_page_contact', 'areaId' => 'footer'));
        $siteHomeBlock5->addArea(array('nodeId' => 'fixture_page_legal_mentions', 'areaId' => 'footer'));

        $siteWhatBlock6 = new Block();
        $siteWhatBlock6->setLabel('What block');
        $siteWhatBlock6->setComponent('tiny_mce_wysiwyg');
        $siteWhatBlock6->setAttributes(array(
            "htmlContent" => "<div class='content3'>  <h3 class='blocTitle'><p class='titleModule'>Actu</p> </h3>   <div class='blockContent'> NEWS</div> </div>",
        ));
        $siteWhatBlock6->addArea(array('nodeId' => 'fixture_page_what_is_orchestra', 'areaId' => 'moduleArea'));
        $siteWhatBlock6->addArea(array('nodeId' => 'fixture_page_start_orchestra', 'areaId' => 'moduleArea'));
        $siteWhatBlock6->addArea(array('nodeId' => 'fixture_page_documentation', 'areaId' => 'moduleArea'));
        $siteWhatBlock6->addArea(array('nodeId' => 'fixture_page_community', 'areaId' => 'moduleArea'));
        $siteWhatBlock6->addArea(array('nodeId' => 'fixture_page_about_us', 'areaId' => 'moduleArea'));
        $siteWhatBlock6->addArea(array('nodeId' => 'fixture_page_our_team', 'areaId' => 'moduleArea'));
        $siteWhatBlock6->addArea(array('nodeId' => 'fixture_page_news', 'areaId' => 'moduleArea'));
        $siteWhatBlock6->addArea(array('nodeId' => 'fixture_page_join_us', 'areaId' => 'moduleArea'));
        $siteWhatBlock6->addArea(array('nodeId' => 'fixture_page_networks', 'areaId' => 'moduleArea'));

        $siteWhatBlock7 = new Block();
        $siteWhatBlock7->setLabel('Contact');
        $siteWhatBlock7->setComponent('contact');
        $siteWhatBlock7->setAttributes(array(
            "id" => "myFormContact",
            "class" => "myFormContact",
        ));
        $siteWhatBlock7->addArea(array('nodeId' => 'fixture_page_what_is_orchestra', 'areaId' => 'moduleArea'));
        $siteWhatBlock7->addArea(array('nodeId' => 'fixture_page_start_orchestra', 'areaId' => 'moduleArea'));
        $siteWhatBlock7->addArea(array('nodeId' => 'fixture_page_documentation', 'areaId' => 'moduleArea'));
        $siteWhatBlock7->addArea(array('nodeId' => 'fixture_page_community', 'areaId' => 'moduleArea'));
        $siteWhatBlock7->addArea(array('nodeId' => 'fixture_page_about_us', 'areaId' => 'moduleArea'));
        $siteWhatBlock7->addArea(array('nodeId' => 'fixture_page_our_team', 'areaId' => 'moduleArea'));
        $siteWhatBlock7->addArea(array('nodeId' => 'fixture_page_news', 'areaId' => 'moduleArea'));
        $siteWhatBlock7->addArea(array('nodeId' => 'fixture_page_join_us', 'areaId' => 'moduleArea'));
        $siteWhatBlock7->addArea(array('nodeId' => 'fixture_page_networks', 'areaId' => 'moduleArea'));

        $siteHomeArea1 = new Area();
        $siteHomeArea1->setLabel('Logo');
        $siteHomeArea1->setAreaId('logo');
        $siteHomeArea1->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteHomeArea2 = new Area();
        $siteHomeArea2->setLabel('Sub menu');
        $siteHomeArea2->setAreaId('sub_menu');
        $siteHomeArea2->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteHomeArea3 = new Area();
        $siteHomeArea3->setLabel('Main menu');
        $siteHomeArea3->setAreaId('main_menu');
        $siteHomeArea3->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteHomeArea0 = new Area();
        $siteHomeArea0->setLabel('Header');
        $siteHomeArea0->setAreaId('header');
        $siteHomeArea0->addArea($siteHomeArea1);
        $siteHomeArea0->addArea($siteHomeArea2);
        $siteHomeArea0->addArea($siteHomeArea3);

        $siteHomeArea5 = new Area();
        $siteHomeArea5->setLabel('Main content carrousel');
        $siteHomeArea5->setAreaId('mainContentCarrousel');
        $siteHomeArea5->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteHomeArea6 = new Area();
        $siteHomeArea6->setLabel('Main content area 2');
        $siteHomeArea6->setAreaId('mainContentArea2');
        $siteHomeArea6->addBlock(array('nodeId' => 0, 'blockId' => 4));

        $siteHomeArea4 = new Area();
        $siteHomeArea4->setLabel('My main');
        $siteHomeArea4->setAreaId('myMain');
        $siteHomeArea4->addArea($siteHomeArea5);
        $siteHomeArea4->addArea($siteHomeArea6);

        $siteHomeFooter = new Area();
        $siteHomeFooter->setLabel('Containe footer');
        $siteHomeFooter->setAreaId('containeFooter');
        $siteHomeFooter->addBlock(array('nodeId' => 0, 'blockId' => 5));

        $siteHomeContainerFooter = new Area();
        $siteHomeContainerFooter->setLabel('Footer');
        $siteHomeContainerFooter->setAreaId('footer');
        $siteHomeContainerFooter->addArea($siteHomeFooter);

        $siteHome = new Node();
        $siteHome->setNodeId('root');
        $siteHome->setNodeType('page');
        $siteHome->setName('Home');
        $siteHome->setSiteId('2');
        $siteHome->setParentId('-');
        $siteHome->setPath('-');
        $siteHome->setAlias('page-home');
        $siteHome->setVersion(1);
        $siteHome->setLanguage('fr');
        $siteHome->setStatus($this->getReference('status-published'));
        $siteHome->setDeleted(false);
        $siteHome->setTemplateId('');
        $siteHome->setTheme('themePresentation');
        $siteHome->setInFooter(false);
        $siteHome->setInMenu(true);
        $siteHome->addArea($siteHomeArea0);
        $siteHome->addArea($siteHomeArea4);
        $siteHome->addArea($siteHomeContainerFooter);
        $siteHome->addBlock($siteHomeBlock0);
        $siteHome->addBlock($siteHomeBlock1);
        $siteHome->addBlock($siteHomeBlockMenu);
        $siteHome->addBlock($siteHomeCarrousel);
        $siteHome->addBlock($siteHomeBlock4);
        $siteHome->addBlock($siteHomeBlock5);
        $siteHome->addBlock($siteWhatBlock6);
        $siteHome->addBlock($siteWhatBlock7);

        return $siteHome;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteWhatIsOrchestra()
    {
        $siteWhatBlock0 = new Block();
        $siteWhatBlock0->setLabel('Wysiwyg');
        $siteWhatBlock0->setComponent('tiny_mce_wysiwyg');
        $siteWhatBlock0->setAttributes(array(
            "htmlContent" => "<div class='content2'><h1>PHPOrchestra</h1><p>
PHP Orchestra est une plateforme développée conjointement par Interakting et Zend Technologies. Cette offre, dédiée au marketing est destinée aux grands projets de nouvelle génération en digital marketing et entreprise 2.0.

L’objectif de PHP Factory est de répondre aux exigences les plus élevées des grands comptes en termes de haute disponibilité, de performance et d'industrialisation des processus de création et de diffusion de contenus vers le Web et les mobiles.

Elle a été développé  autour des standards PHP de Zend. Elle est constituée d’une bibliothèque de composants : gestion de contenu web et multi-média, d’e-commerce, d’animation de réseaux sociaux, de Portail et de Mobilité.
PHP FACTORY est la solution omnicanal qui accélère la construction de votre écosysteme digital.

Quelles que soient les interactions entre une marque et ses clients, quel que soit l’écran, quel que soit le terminal, l’expérience se construit à chaque point de contact.

Notre promesse : « Economies d’échelle et mutualisation des investissements pour une expérience web cohérente sur tous les canaux fixe mobile, tablette, TV, bornes… »
<br>
Une solution ciblée : <br>

Projet où «l’expérience», qu’elle soit clients, collaborateurs, partenaires ou distributeurs est au cœur de la problématique.<br>
Projet à dimension internationale nécessitant des économies d’échelles.<br>
Projet avec des équations complexes à résoudre et où les systèmes d’informations internes et partenaires sont fortement sollicités.<br>
Projet dont l’objectif est de bâtir des écosystèmes digitaux (e-commerce, communication, référentiel, selfcare, mobilité, distribution, …) cohérents avec des synergies fonctionnelles et technologiques.<br>
Nativement, multi-sites multi support, facile d’intégration au SI, ouvert vers l’extérieur, taillé pour les fortes charges et la sécurité, modulaire (tout est composant, modèle HMVC), 100% Zend.<br>
               </p></div>",
        ));
        $siteWhatBlock0->addArea(array('nodeId' => 0, 'areaId' => 'mainContentArea1'));

        $siteWhatArea1 = new Area();
        $siteWhatArea1->setLabel('Logo');
        $siteWhatArea1->setAreaId('logo');
        $siteWhatArea1->addBlock(array('nodeId' => 'root', 'blockId' => 0));

        $siteWhatArea2 = new Area();
        $siteWhatArea2->setLabel('Sub menu');
        $siteWhatArea2->setAreaId('sub_menu');
        $siteWhatArea2->addBlock(array('nodeId' => 'root', 'blockId' => 1));

        $siteWhatArea3 = new Area();
        $siteWhatArea3->setLabel('Main menu');
        $siteWhatArea3->setAreaId('main_menu');
        $siteWhatArea3->addBlock(array('nodeId' => 'root', 'blockId' => 2));

        $siteWhatArea0 = new Area();
        $siteWhatArea0->setLabel('Header');
        $siteWhatArea0->setAreaId('header');
        $siteWhatArea0->addArea($siteWhatArea1);
        $siteWhatArea0->addArea($siteWhatArea2);
        $siteWhatArea0->addArea($siteWhatArea3);

        $siteWhatArea5 = new Area();
        $siteWhatArea5->setLabel('Main content area 1');
        $siteWhatArea5->setAreaId('mainContentArea1');
        $siteWhatArea5->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteWhatArea6 = new Area();
        $siteWhatArea6->setLabel('Module area');
        $siteWhatArea6->setAreaId('moduleArea');
        $siteWhatArea6->addBlock(array('nodeId' => 'root', 'blockId' => 6));
        $siteWhatArea6->addBlock(array('nodeId' => 'root', 'blockId' => 7));

        $siteWhatArea4 = new Area();
        $siteWhatArea4->setLabel('My main');
        $siteWhatArea4->setAreaId('myMain');
        $siteWhatArea4->addArea($siteWhatArea5);
        $siteWhatArea4->addArea($siteWhatArea6);

        $siteWhatArea8 = new Area();
        $siteWhatArea8->setLabel('Containe footer');
        $siteWhatArea8->setAreaId('containeFooter');
        $siteWhatArea8->addBlock(array('nodeId' => 'root', 'blockId' => 5));

        $siteWhatArea7 = new Area();
        $siteWhatArea7->setLabel('Footer');
        $siteWhatArea7->setAreaId('footer');
        $siteWhatArea7->addArea($siteWhatArea8);

        $siteWhat = new Node();
        $siteWhat->setNodeId('fixture_page_what_is_orchestra');
        $siteWhat->setNodeType('page');
        $siteWhat->setName('Orchestra ?');
        $siteWhat->setSiteId('2');
        $siteWhat->setParentId('root');
        $siteWhat->setPath('-');
        $siteWhat->setAlias('page-what-is-orchestra');
        $siteWhat->setVersion(1);
        $siteWhat->setLanguage('fr');
        $siteWhat->setStatus($this->getReference('status-published'));
        $siteWhat->setDeleted(false);
        $siteWhat->setTemplateId('');
        $siteWhat->setTheme('themePresentation');
        $siteWhat->setInFooter(false);
        $siteWhat->setInMenu(true);
        $siteWhat->addArea($siteWhatArea0);
        $siteWhat->addArea($siteWhatArea4);
        $siteWhat->addArea($siteWhatArea7);
        $siteWhat->addBlock($siteWhatBlock0);

        return $siteWhat;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteStartOrchestra()
    {
        $siteStartBlock0 = new Block();
        $siteStartBlock0->setLabel('Wysiwyg');
        $siteStartBlock0->setComponent('tiny_mce_wysiwyg');
        $siteStartBlock0->setAttributes(array(
            "htmlContent" => "<div class='content2'> <h1>Le tour rapide</h1>
            <p>
            Quoi de mieux pour se faire un avis que d'essayer Symfony par vous même ? À part un peu de temps, cela ne vous coûtera rien. Pas à pas vous allez explorer l'univers de Symfony. Attention, Symfony peut vite devenir addictif dès la première rencontre.
            </p>
            </div>",
        ));
        $siteStartBlock0->addArea(array('nodeId' => 0, 'areaId' => 'mainContentArea1'));

        $siteStartArea1 = new Area();
        $siteStartArea1->setLabel('Logo');
        $siteStartArea1->setAreaId('logo');
        $siteStartArea1->addBlock(array('nodeId' => 'root', 'blockId' => 0));

        $siteStartArea2 = new Area();
        $siteStartArea2->setLabel('Sub menu');
        $siteStartArea2->setAreaId('sub_menu');
        $siteStartArea2->addBlock(array('nodeId' => 'root', 'blockId' => 1));

        $siteStartArea3 = new Area();
        $siteStartArea3->setLabel('Main menu');
        $siteStartArea3->setAreaId('main_menu');
        $siteStartArea3->addBlock(array('nodeId' => 'root', 'blockId' => 2));

        $siteStartArea0 = new Area();
        $siteStartArea0->setLabel('Header');
        $siteStartArea0->setAreaId('header');
        $siteStartArea0->addArea($siteStartArea1);
        $siteStartArea0->addArea($siteStartArea2);
        $siteStartArea0->addArea($siteStartArea3);

        $siteStartArea5 = new Area();
        $siteStartArea5->setLabel('Main content area 1');
        $siteStartArea5->setAreaId('mainContentArea1');
        $siteStartArea5->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteStartArea6 = new Area();
        $siteStartArea6->setLabel('Module area');
        $siteStartArea6->setAreaId('moduleArea');
        $siteStartArea6->addBlock(array('nodeId' => 'root', 'blockId' => 6));
        $siteStartArea6->addBlock(array('nodeId' => 'root', 'blockId' => 7));

        $siteStartArea4 = new Area();
        $siteStartArea4->setLabel('My main');
        $siteStartArea4->setAreaId('myMain');
        $siteStartArea4->addArea($siteStartArea5);
        $siteStartArea4->addArea($siteStartArea6);

        $siteStartArea8 = new Area();
        $siteStartArea8->setLabel('Containe footer');
        $siteStartArea8->setAreaId('containeFooter');
        $siteStartArea8->addBlock(array('nodeId' => 'root', 'blockId' => 5));

        $siteStartArea7 = new Area();
        $siteStartArea7->setLabel('Footer');
        $siteStartArea7->setAreaId('footer');
        $siteStartArea7->addArea($siteStartArea8);

        $siteStart = new Node();
        $siteStart->setNodeId('fixture_page_start_orchestra');
        $siteStart->setNodeType('page');
        $siteStart->setName('Get Started');
        $siteStart->setSiteId('2');
        $siteStart->setParentId('root');
        $siteStart->setPath('-');
        $siteStart->setAlias('page-start-orchestra');
        $siteStart->setVersion(1);
        $siteStart->setLanguage('fr');
        $siteStart->setStatus($this->getReference('status-published'));
        $siteStart->setDeleted(false);
        $siteStart->setTemplateId('');
        $siteStart->setTheme('themePresentation');
        $siteStart->setInFooter(false);
        $siteStart->setInMenu(true);
        $siteStart->addArea($siteStartArea0);
        $siteStart->addArea($siteStartArea4);
        $siteStart->addArea($siteStartArea7);
        $siteStart->addBlock($siteStartBlock0);

        return $siteStart;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteDocumentation()
    {
        $siteDocBlock0 = new Block();
        $siteDocBlock0->setLabel('Wysiwyg');
        $siteDocBlock0->setComponent('tiny_mce_wysiwyg 1');
        $siteDocBlock0->setAttributes(array(
            "htmlContent" => "<div class='content2'> <h1>PHP Documentation</h1>
                <p>The PHP Manual is available online in a selection of languages. Please pick a language from the list below.

More information about php.net URL shortcuts by visiting our URL howto page.

Note, that many languages are just under translation, and the untranslated parts are still in English. Also some translated parts might be outdated. The translation teams are open to contributions.</p>
            </div>",
        ));
        $siteDocBlock0->addArea(array('nodeId' => 0, 'areaId' => 'mainContentArea1'));

        $siteDocArea1 = new Area();
        $siteDocArea1->setLabel('Logo');
        $siteDocArea1->setAreaId('logo');
        $siteDocArea1->addBlock(array('nodeId' => 'root', 'blockId' => 0));

        $siteDocArea2 = new Area();
        $siteDocArea2->setLabel('Sub menu');
        $siteDocArea2->setAreaId('sub_menu');
        $siteDocArea2->addBlock(array('nodeId' => 'root', 'blockId' => 1));

        $siteDocArea3 = new Area();
        $siteDocArea3->setLabel('Main menu');
        $siteDocArea3->setAreaId('main_menu');
        $siteDocArea3->addBlock(array('nodeId' => 'root', 'blockId' => 2));

        $siteDocArea0 = new Area();
        $siteDocArea0->setLabel('Header');
        $siteDocArea0->setAreaId('header');
        $siteDocArea0->addArea($siteDocArea1);
        $siteDocArea0->addArea($siteDocArea2);
        $siteDocArea0->addArea($siteDocArea3);

        $siteDocArea5 = new Area();
        $siteDocArea5->setLabel('Main content area 1');
        $siteDocArea5->setAreaId('mainContentArea1');
        $siteDocArea5->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteDocArea6 = new Area();
        $siteDocArea6->setLabel('Module area');
        $siteDocArea6->setAreaId('moduleArea');
        $siteDocArea6->addBlock(array('nodeId' => 'root', 'blockId' => 6));
        $siteDocArea6->addBlock(array('nodeId' => 'root', 'blockId' => 7));

        $siteDocArea4 = new Area();
        $siteDocArea4->setLabel('My main');
        $siteDocArea4->setAreaId('myMain');
        $siteDocArea4->addArea($siteDocArea5);
        $siteDocArea4->addArea($siteDocArea6);

        $siteDocArea8 = new Area();
        $siteDocArea8->setLabel('Containe footer');
        $siteDocArea8->setAreaId('containeFooter');
        $siteDocArea8->addBlock(array('nodeId' => 'root', 'blockId' => 5));

        $siteDocArea7 = new Area();
        $siteDocArea7->setLabel('Footer');
        $siteDocArea7->setAreaId('footer');
        $siteDocArea7->addArea($siteDocArea8);

        $siteDoc = new Node();
        $siteDoc->setNodeId('fixture_page_documentation');
        $siteDoc->setNodeType('page');
        $siteDoc->setName('Documentation');
        $siteDoc->setSiteId('2');
        $siteDoc->setParentId('root');
        $siteDoc->setPath('-');
        $siteDoc->setAlias('page-documentation');
        $siteDoc->setVersion(1);
        $siteDoc->setLanguage('fr');
        $siteDoc->setStatus($this->getReference('status-published'));
        $siteDoc->setDeleted(false);
        $siteDoc->setTemplateId('');
        $siteDoc->setTheme('themePresentation');
        $siteDoc->setInFooter(false);
        $siteDoc->setInMenu(true);
        $siteDoc->addArea($siteDocArea0);
        $siteDoc->addArea($siteDocArea4);
        $siteDoc->addArea($siteDocArea7);
        $siteDoc->addBlock($siteDocBlock0);

        return $siteDoc;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteCommunity()
    {
        $siteComBlock0 = new Block();
        $siteComBlock0->setLabel('Wysiwyg 1');
        $siteComBlock0->setComponent('tiny_mce_wysiwyg');
        $siteComBlock0->setAttributes(array(
            "htmlContent" => "<div class='content2'> <h1>ENTREPRISE DIGITALE : LES LEVIERS DE LA PERFORMANCE</h1>
                <p>
                    L’Entreprise Digitale n’est plus un concept abstrait mais bien un formidable levier de la performance.

Pour interakting, l’entreprise digitale regroupe toutes les initatives autour des relations collaborateurs, partenaires, distributeurs, l’amélioration des processus avec des applications métiers repensées et l’industrialisation de la communication institutionnelle. Agilité, rapidité, fluidité et interactions sont les maîtres mots.

Pour les collaborateurs, l’accent est mis sur les réseaux sociaux d’entreprise, les plateformes collaboratives et le social business.
Pour les partenaires et distributeurs, c’est le commerce B2B, les espaces clients (selfcare) de nouvelles générations, le feedback management et la cocréation qui sont au devant de la scène.
Pour la communication institutionnelle, être capable de gérer une communication de crise, une empreinte digitale et sa réputation au niveau international est une préoccupation principale.

Enfin, la digitalisation des applications et les stratégies mobiles de l’entreprise (équipement des vendeurs et des intermédiaires), les dispositifs relations B2B2C, sont aujourd’hui les nouveaux challenges.
                </p>
            </div>",
        ));
        $siteComBlock0->addArea(array('nodeId' => 0, 'areaId' => 'mainContentArea1'));

        $siteComArea1 = new Area();
        $siteComArea1->setLabel('Logo');
        $siteComArea1->setAreaId('logo');
        $siteComArea1->addBlock(array('nodeId' => 'root', 'blockId' => 0));

        $siteComArea2 = new Area();
        $siteComArea2->setLabel('Sub menu');
        $siteComArea2->setAreaId('sub_menu');
        $siteComArea2->addBlock(array('nodeId' => 'root', 'blockId' => 1));

        $siteComArea3 = new Area();
        $siteComArea3->setLabel('Main menu');
        $siteComArea3->setAreaId('main_menu');
        $siteComArea3->addBlock(array('nodeId' => 'root', 'blockId' => 2));

        $siteComArea0 = new Area();
        $siteComArea0->setLabel('Header');
        $siteComArea0->setAreaId('header');
        $siteComArea0->addArea($siteComArea1);
        $siteComArea0->addArea($siteComArea2);
        $siteComArea0->addArea($siteComArea3);

        $siteComArea5 = new Area();
        $siteComArea5->setLabel('Main content area 1');
        $siteComArea5->setAreaId('mainContentArea1');
        $siteComArea5->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteComArea6 = new Area();
        $siteComArea6->setLabel('module area');
        $siteComArea6->setAreaId('moduleArea');
        $siteComArea6->addBlock(array('nodeId' => 'root', 'blockId' => 6));
        $siteComArea6->addBlock(array('nodeId' => 'root', 'blockId' => 6));

        $siteComArea4 = new Area();
        $siteComArea4->setLabel('My main');
        $siteComArea4->setAreaId('myMain');
        $siteComArea4->addArea($siteComArea5);
        $siteComArea4->addArea($siteComArea6);

        $siteComArea8 = new Area();
        $siteComArea8->setLabel('Containe footer');
        $siteComArea8->setAreaId('containeFooter');
        $siteComArea8->addBlock(array('nodeId' => 'root', 'blockId' => 5));

        $siteComArea7 = new Area();
        $siteComArea7->setLabel('Footer');
        $siteComArea7->setAreaId('footer');
        $siteComArea7->addArea($siteComArea8);

        $siteCom = new Node();
        $siteCom->setNodeId('fixture_page_community');
        $siteCom->setNodeType('page');
        $siteCom->setName('Communauté');
        $siteCom->setSiteId('2');
        $siteCom->setParentId('root');
        $siteCom->setPath('-');
        $siteCom->setAlias('page-community');
        $siteCom->setVersion(1);
        $siteCom->setLanguage('fr');
        $siteCom->setStatus($this->getReference('status-published'));
        $siteCom->setDeleted(false);
        $siteCom->setTemplateId('');
        $siteCom->setTheme('themePresentation');
        $siteCom->setInFooter(false);
        $siteCom->setInMenu(true);
        $siteCom->addArea($siteComArea0);
        $siteCom->addArea($siteComArea4);
        $siteCom->addArea($siteComArea7);
        $siteCom->addBlock($siteComBlock0);

        return $siteCom;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteAboutUs()
    {
        $siteAboutUsBlock0 = new Block();
        $siteAboutUsBlock0->setLabel('Wysiwyg 1');
        $siteAboutUsBlock0->setComponent('tiny_mce_wysiwyg');
        $siteAboutUsBlock0->setAttributes(array(
            "htmlContent" => "<div class='content2'> <h1>Interakting</h1>
                <p>
                Une agence digitale nouvelle génération classée par le Forrester parmi les 12 plus grandes agences européennes, avec un positionnement conseil et technologies.
                Une division du groupe Business&Decision
                Business & Decision est un Groupe international de services numériques,  leader de la Business Intelligence (BI) et du CRM, acteur majeur de l'e-Business.  Le Groupe contribue à la réussite des projets à forte valeur ajoutée des entreprises et accompagne ses clients dans des domaines d’innovation tels que le Big Data et le Digital. Il est reconnu pour son expertise fonctionnelle et technologique par les plus grands éditeurs de logiciels du marché avec lesquels il a noué des partenariats. Fort d’une expertise unique dans ses domaines de spécialisation, Business & Decision offre des solutions adaptées à des secteurs d’activité ainsi qu’à des directions métiers.
                </p>
            </div>",
        ));
        $siteAboutUsBlock0->addArea(array('nodeId' => 0, 'areaId' => 'mainContentArea1'));

        $siteAboutUsArea1 = new Area();
        $siteAboutUsArea1->setLabel('Logo');
        $siteAboutUsArea1->setAreaId('logo');
        $siteAboutUsArea1->addBlock(array('nodeId' => 'root', 'blockId' => 0));

        $siteAboutUsArea2 = new Area();
        $siteAboutUsArea2->setLabel('Sub menu');
        $siteAboutUsArea2->setAreaId('sub_menu');
        $siteAboutUsArea2->addBlock(array('nodeId' => 'root', 'blockId' => 1));

        $siteAboutUsArea3 = new Area();
        $siteAboutUsArea3->setLabel('Main menu');
        $siteAboutUsArea3->setAreaId('main_menu');
        $siteAboutUsArea3->addBlock(array('nodeId' => 'root', 'blockId' => 2));

        $siteAboutUsArea0 = new Area();
        $siteAboutUsArea0->setLabel('Header');
        $siteAboutUsArea0->setAreaId('header');
        $siteAboutUsArea0->addArea($siteAboutUsArea1);
        $siteAboutUsArea0->addArea($siteAboutUsArea2);
        $siteAboutUsArea0->addArea($siteAboutUsArea3);

        $siteAboutUsArea5 = new Area();
        $siteAboutUsArea5->setLabel('Main content area 1');
        $siteAboutUsArea5->setAreaId('mainContentArea1');
        $siteAboutUsArea5->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteAboutUsArea6 = new Area();
        $siteAboutUsArea6->setLabel('Module area');
        $siteAboutUsArea6->setAreaId('moduleArea');
        $siteAboutUsArea6->addBlock(array('nodeId' => 'root', 'blockId' => 6));
        $siteAboutUsArea6->addBlock(array('nodeId' => 'root', 'blockId' => 7));

        $siteAboutUsArea4 = new Area();
        $siteAboutUsArea4->setLabel('My main');
        $siteAboutUsArea4->setAreaId('myMain');
        $siteAboutUsArea4->addArea($siteAboutUsArea5);
        $siteAboutUsArea4->addArea($siteAboutUsArea6);

        $siteAboutUsArea8 = new Area();
        $siteAboutUsArea8->setLabel('Containe footer');
        $siteAboutUsArea8->setAreaId('containeFooter');
        $siteAboutUsArea8->addBlock(array('nodeId' => 'root', 'blockId' => 5));

        $siteAboutUsArea7 = new Area();
        $siteAboutUsArea7->setLabel('Footer');
        $siteAboutUsArea7->setAreaId('footer');
        $siteAboutUsArea7->addArea($siteAboutUsArea8);

        $siteAboutUs = new Node();
        $siteAboutUs->setNodeId('fixture_page_about_us');
        $siteAboutUs->setNodeType('page');
        $siteAboutUs->setName('A propos');
        $siteAboutUs->setSiteId('2');
        $siteAboutUs->setParentId('root');
        $siteAboutUs->setPath('-');
        $siteAboutUs->setAlias('page-about-us');
        $siteAboutUs->setVersion(1);
        $siteAboutUs->setLanguage('fr');
        $siteAboutUs->setStatus($this->getReference('status-published'));
        $siteAboutUs->setDeleted(false);
        $siteAboutUs->setTemplateId('');
        $siteAboutUs->setTheme('themePresentation');
        $siteAboutUs->setInFooter(false);
        $siteAboutUs->setInMenu(false);
        $siteAboutUs->addArea($siteAboutUsArea0);
        $siteAboutUs->addArea($siteAboutUsArea4);
        $siteAboutUs->addArea($siteAboutUsArea7);
        $siteAboutUs->addBlock($siteAboutUsBlock0);

        return $siteAboutUs;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteOurTeam()
    {
        $siteOurTeamBlock0 = new Block();
        $siteOurTeamBlock0->setLabel('Wysiwyg 1');
        $siteOurTeamBlock0->setComponent('tiny_mce_wysiwyg');
        $siteOurTeamBlock0->setAttributes(array(
            "htmlContent" => "<div class='content2'> <h1>Our Team</h1>
            <br>
            <p>
            Une agence digitale nouvelle génération classée par le Forrester parmi les 12 plus grandes agences européennes, avec un positionnement conseil et technologies.<br>
            Une présence internationale, un modèle de delivery industriel, une organisation en centre de services, des plateformes near shore et off shore.<br>
            pour les grands projets de transformation « digital » et pour adresser les marchés du « customer experience management), entreprise digitale et secteur public.<br>
            Partenaire stratégique des grands projets, nos interventions s’inscrivent dans la durée.
            </p>
            </div>",
        ));
        $siteOurTeamBlock0->addArea(array('nodeId' => 0, 'areaId' => 'mainContentArea1'));

        $siteOurTeamArea1 = new Area();
        $siteOurTeamArea1->setLabel('Logo');
        $siteOurTeamArea1->setAreaId('logo');
        $siteOurTeamArea1->addBlock(array('nodeId' => 'root', 'blockId' => 0));

        $siteOurTeamArea2 = new Area();
        $siteOurTeamArea2->setLabel('Sub menu');
        $siteOurTeamArea2->setAreaId('sub_menu');
        $siteOurTeamArea2->addBlock(array('nodeId' => 'root', 'blockId' => 1));

        $siteOurTeamArea3 = new Area();
        $siteOurTeamArea3->setLabel('Main menu');
        $siteOurTeamArea3->setAreaId('main_menu');
        $siteOurTeamArea3->addBlock(array('nodeId' => 'root', 'blockId' => 2));

        $siteOurTeamArea0 = new Area();
        $siteOurTeamArea0->setLabel('Header');
        $siteOurTeamArea0->setAreaId('header');
        $siteOurTeamArea0->addArea($siteOurTeamArea1);
        $siteOurTeamArea0->addArea($siteOurTeamArea2);
        $siteOurTeamArea0->addArea($siteOurTeamArea3);

        $siteOurTeamArea5 = new Area();
        $siteOurTeamArea5->setLabel('Main content area 1');
        $siteOurTeamArea5->setAreaId('mainContentArea1');
        $siteOurTeamArea5->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteOurTeamArea6 = new Area();
        $siteOurTeamArea6->setLabel('Module area');
        $siteOurTeamArea6->setAreaId('moduleArea');
        $siteOurTeamArea6->addBlock(array('nodeId' => 'root', 'blockId' => 6));
        $siteOurTeamArea6->addBlock(array('nodeId' => 'root', 'blockId' => 7));

        $siteOurTeamArea4 = new Area();
        $siteOurTeamArea4->setLabel('My main');
        $siteOurTeamArea4->setAreaId('myMain');
        $siteOurTeamArea4->addArea($siteOurTeamArea5);
        $siteOurTeamArea4->addArea($siteOurTeamArea6);

        $siteOurTeamArea8 = new Area();
        $siteOurTeamArea8->setLabel('Containe footer');
        $siteOurTeamArea8->setAreaId('containeFooter');
        $siteOurTeamArea8->addBlock(array('nodeId' => 'root', 'blockId' => 5));

        $siteOurTeamArea7 = new Area();
        $siteOurTeamArea7->setLabel('Footer');
        $siteOurTeamArea7->setAreaId('footer');
        $siteOurTeamArea7->addArea($siteOurTeamArea8);

        $siteOurTeam = new Node();
        $siteOurTeam->setNodeId('fixture_page_our_team');
        $siteOurTeam->setNodeType('page');
        $siteOurTeam->setName('Fixture page our team');
        $siteOurTeam->setSiteId('2');
        $siteOurTeam->setParentId('root');
        $siteOurTeam->setPath('-');
        $siteOurTeam->setAlias('page-our-team');
        $siteOurTeam->setVersion(1);
        $siteOurTeam->setLanguage('fr');
        $siteOurTeam->setStatus($this->getReference('status-published'));
        $siteOurTeam->setDeleted(false);
        $siteOurTeam->setTemplateId('');
        $siteOurTeam->setTheme('themePresentation');
        $siteOurTeam->setInFooter(false);
        $siteOurTeam->setInMenu(false);
        $siteOurTeam->addArea($siteOurTeamArea0);
        $siteOurTeam->addArea($siteOurTeamArea4);
        $siteOurTeam->addArea($siteOurTeamArea7);
        $siteOurTeam->addBlock($siteOurTeamBlock0);

        return $siteOurTeam;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteNews()
    {
        $siteNewsBlock0 = new Block();
        $siteNewsBlock0->setLabel('Wysiwyg 1');
        $siteNewsBlock0->setComponent('tiny_mce_wysiwyg');
        $siteNewsBlock0->setAttributes(array(
            "htmlContent" => "<div class='content2'> <h1>Actu</h1>
            <br>
            <p>
            <h2>ZADIG & VOLTAIRE PUBLIE SES MAGAZINES SUR IPAD AVEC INTERAKTING</h2><br>
            Zadig & Voltaire étend et enrichit ses activités commerciales à travers des sites web marchands, les réseaux sociaux et des applications mobiles. L’équipe Marketing Digital de Zadig & Voltaire a opté d’une part pour le développement d’un site mobile, dupliqué du site marchand internet, et d’autre part d’une application iPad pour publier des magazines dérivés de ses catalogues papier. L’objectif de l’application iPad consiste à allier graphisme, ergonomie, interactivité, géolocalisation et e-Commerce pour ainsi développer la visibilité de la marque tout en créant une approche inédite du e-shopping.<br>
            <h2>FUN DISTINGUÉ PAR LE GRAND PRIX DES LECTEURS D’ACTEURS PUBLICS COMME LA MEILLEURE INITIATIVE PUBLIQUE DE L’ANNÉE!</h2><br>
            Le site du Ministère de l’Enseignement supérieur et de la Recherche, <a href='http://businessdecision.us3.list-manage2.com/track/click?u=cf8b0e95565b3f0a524bea0a6&id=b321193023&e=3ec73c652f'>http://www.france-universite-numerique.fr</a>, pour lequel Interakting a réalisé l’ensemble de l’intégration HTML, a remporté le prix des meilleurs initiatives de l’année 2013 par le magazine Acteurs Publics.
Ces Victoires mettent en lumière celles et ceux qui, chaque jour, agissent pour assurer le meilleur du service au public.
            </p>
            </div>",
        ));
        $siteNewsBlock0->addArea(array('nodeId' => 0, 'areaId' => 'mainContentArea1'));

        $siteNewsArea1 = new Area();
        $siteNewsArea1->setLabel('Logo');
        $siteNewsArea1->setAreaId('logo');
        $siteNewsArea1->addBlock(array('nodeId' => 'root', 'blockId' => 0));

        $siteNewsArea2 = new Area();
        $siteNewsArea2->setLabel('Sub menu');
        $siteNewsArea2->setAreaId('sub_menu');
        $siteNewsArea2->addBlock(array('nodeId' => 'root', 'blockId' => 1));

        $siteNewsArea3 = new Area();
        $siteNewsArea3->setLabel('Main menu');
        $siteNewsArea3->setAreaId('main_menu');
        $siteNewsArea3->addBlock(array('nodeId' => 'root', 'blockId' => 2));

        $siteNewsArea0 = new Area();
        $siteNewsArea0->setLabel('Header');
        $siteNewsArea0->setAreaId('header');
        $siteNewsArea0->addArea($siteNewsArea1);
        $siteNewsArea0->addArea($siteNewsArea2);
        $siteNewsArea0->addArea($siteNewsArea3);

        $siteNewsArea5 = new Area();
        $siteNewsArea5->setLabel('Main content area 1');
        $siteNewsArea5->setAreaId('mainContentArea1');
        $siteNewsArea5->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteNewsArea6 = new Area();
        $siteNewsArea6->setLabel('Module area');
        $siteNewsArea6->setAreaId('moduleArea');
        $siteNewsArea6->addBlock(array('nodeId' => 'root', 'blockId' => 6));
        $siteNewsArea6->addBlock(array('nodeId' => 'root', 'blockId' => 7));

        $siteNewsArea4 = new Area();
        $siteNewsArea4->setLabel('My main');
        $siteNewsArea4->setAreaId('myMain');
        $siteNewsArea4->addArea($siteNewsArea5);
        $siteNewsArea4->addArea($siteNewsArea6);

        $siteNewsArea8 = new Area();
        $siteNewsArea8->setLabel('Containe footer');
        $siteNewsArea8->setAreaId('containeFooter');
        $siteNewsArea8->addBlock(array('nodeId' => 'root', 'blockId' => 5));

        $siteNewsArea7 = new Area();
        $siteNewsArea7->setLabel('Footer');
        $siteNewsArea7->setAreaId('footer');
        $siteNewsArea7->addArea($siteNewsArea8);

        $siteNews = new Node();
        $siteNews->setNodeId('fixture_page_news');
        $siteNews->setNodeType('page');
        $siteNews->setName('Fixture page news');
        $siteNews->setSiteId('2');
        $siteNews->setParentId('root');
        $siteNews->setPath('-');
        $siteNews->setAlias('page-our-news');
        $siteNews->setVersion(1);
        $siteNews->setLanguage('fr');
        $siteNews->setStatus($this->getReference('status-published'));
        $siteNews->setDeleted(false);
        $siteNews->setTemplateId('');
        $siteNews->setTheme('themePresentation');
        $siteNews->setInFooter(false);
        $siteNews->setInMenu(false);
        $siteNews->addArea($siteNewsArea0);
        $siteNews->addArea($siteNewsArea4);
        $siteNews->addArea($siteNewsArea7);
        $siteNews->addBlock($siteNewsBlock0);

        return $siteNews;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteJoinUs()
    {
        $siteJoinUsBlock0 = new Block();
        $siteJoinUsBlock0->setLabel('Wysiwyg 1');
        $siteJoinUsBlock0->setComponent('tiny_mce_wysiwyg');
        $siteJoinUsBlock0->setAttributes(array(
            "htmlContent" => "<div class='content2'><div id='annonce'><h1>Nous rejoindre</h1> <p>Vous êtes un passionné d’Internet en général et du Web en particulier?</p> <p>Vous avez une expérience significative dans les domaines suivants: Développement web le framwork Symfony 2 Votre profil est susceptible de nous intéresser </div> <div id='form'><table border='0'><tbody><tr><td valign='top'> Nom   </td><td> <input type='text' placeholder='Votre nom' required/> </td></tr><tr> <td valign='top'> Société   </td><td> <input type='text' placeholder='Votre société'/> </td></tr><tr> <td valign='top'> Email   </td><td> <input type='email' placeholder='Votre e-mail' required/> </td></tr><tr> <td valign='top'> Téléphone </td><td> <input type='tel' placeholder='Votre téléphone' required/> </td></tr><tr> <td valign='top'> Message   </td><td> <textarea  rows='10' cols='25' placeholder='Votre message' required> </textarea> </td></tr><tr> <td valign='top'> CV   </td><td><input type='file' /> </td></tr> <tr> <td> <input type='submit' value='OK'/></td>  </tr> </tbody></table></div> </div>",
        ));
        $siteJoinUsBlock0->addArea(array('nodeId' => 0, 'areaId' => 'mainContentArea1'));

        $siteJoinUsArea1 = new Area();
        $siteJoinUsArea1->setLabel('Logo');
        $siteJoinUsArea1->setAreaId('logo');
        $siteJoinUsArea1->addBlock(array('nodeId' => 'root', 'blockId' => 0));

        $siteJoinUsArea2 = new Area();
        $siteJoinUsArea2->setLabel('Sub menu');
        $siteJoinUsArea2->setAreaId('sub_menu');
        $siteJoinUsArea2->addBlock(array('nodeId' => 'root', 'blockId' => 1));

        $siteJoinUsArea3 = new Area();
        $siteJoinUsArea3->setLabel('Main menu');
        $siteJoinUsArea3->setAreaId('main_menu');
        $siteJoinUsArea3->addBlock(array('nodeId' => 'root', 'blockId' => 2));

        $siteJoinUsArea0 = new Area();
        $siteJoinUsArea0->setLabel('Header');
        $siteJoinUsArea0->setAreaId('header');
        $siteJoinUsArea0->addArea($siteJoinUsArea1);
        $siteJoinUsArea0->addArea($siteJoinUsArea2);
        $siteJoinUsArea0->addArea($siteJoinUsArea3);

        $siteJoinUsArea5 = new Area();
        $siteJoinUsArea5->setLabel('Main content area 1');
        $siteJoinUsArea5->setAreaId('mainContentArea1');
        $siteJoinUsArea5->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteJoinUsArea6 = new Area();
        $siteJoinUsArea6->setLabel('Module area');
        $siteJoinUsArea6->setAreaId('moduleArea');
        $siteJoinUsArea6->addBlock(array('nodeId' => 'root', 'blockId' => 6));
        $siteJoinUsArea6->addBlock(array('nodeId' => 'root', 'blockId' => 7));

        $siteJoinUsArea4 = new Area();
        $siteJoinUsArea4->setLabel('My main');
        $siteJoinUsArea4->setAreaId('myMain');
        $siteJoinUsArea4->addArea($siteJoinUsArea5);
        $siteJoinUsArea4->addArea($siteJoinUsArea6);

        $siteJoinUsArea8 = new Area();
        $siteJoinUsArea8->setLabel('Containe footer');
        $siteJoinUsArea8->setAreaId('containeFooter');
        $siteJoinUsArea8->addBlock(array('nodeId' => 'root', 'blockId' => 5));

        $siteJoinUsArea7 = new Area();
        $siteJoinUsArea7->setLabel('Footer');
        $siteJoinUsArea7->setAreaId('footer');
        $siteJoinUsArea7->addArea($siteJoinUsArea8);

        $siteJoinUs = new Node();
        $siteJoinUs->setNodeId('fixture_page_join_us');
        $siteJoinUs->setNodeType('page');
        $siteJoinUs->setName('Fixture page join us');
        $siteJoinUs->setSiteId('2');
        $siteJoinUs->setParentId('root');
        $siteJoinUs->setPath('-');
        $siteJoinUs->setAlias('page-nous-rejoindre');
        $siteJoinUs->setVersion(1);
        $siteJoinUs->setLanguage('fr');
        $siteJoinUs->setStatus($this->getReference('status-published'));
        $siteJoinUs->setDeleted(false);
        $siteJoinUs->setTemplateId('');
        $siteJoinUs->setTheme('themePresentation');
        $siteJoinUs->setInFooter(false);
        $siteJoinUs->setInMenu(false);
        $siteJoinUs->addArea($siteJoinUsArea0);
        $siteJoinUs->addArea($siteJoinUsArea4);
        $siteJoinUs->addArea($siteJoinUsArea7);
        $siteJoinUs->addBlock($siteJoinUsBlock0);

        return $siteJoinUs;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteNetwork()
    {
        $siteNetworkBlock0 = new Block();
        $siteNetworkBlock0->setLabel('Wysiwyg 1');
        $siteNetworkBlock0->setComponent('tiny_mce_wysiwyg');
        $siteNetworkBlock0->setAttributes(array(
            "htmlContent" => "<div class='content2'> <h1>Smart Eolas</h1><p>
            Smart.eolas allie le meilleur du e-commerce et de la gestion de contenus. Jusqu’alors, il n’existait aucune plateforme sur le marché mêlant avec succès des fonctions avancées de gestion de contenus et de catalogue produits. Il y a plus de deux ans, Eolas s’est lancé dans ce vaste chantier : construire une nouvelle plateforme e-Commerce et de gestion de contenus innovante et à l’état de l’art.

Smart.eolas est le fruit de 15 ans d’expérience, à la fois en tant que spécialiste du e-Commerce, du Digital Marketing et en tant qu’opérateur de solutions SaaS. Ce projet a ainsi fait appel aux compétences de toutes les équipes d’Eolas, notamment celles des experts en e-Tailing, issues du rachat du fonds de commerce de Proxi-Business, il y a un an.
            </p></div>",
        ));
        $siteNetworkBlock0->addArea(array('nodeId' => 0, 'areaId' => 'mainContentArea1'));

        $siteNetworkArea1 = new Area();
        $siteNetworkArea1->setLabel('Logo');
        $siteNetworkArea1->setAreaId('logo');
        $siteNetworkArea1->addBlock(array('nodeId' => 'root', 'blockId' => 0));

        $siteNetworkArea2 = new Area();
        $siteNetworkArea2->setLabel('Sub menu');
        $siteNetworkArea2->setAreaId('sub_menu');
        $siteNetworkArea2->addBlock(array('nodeId' => 'root', 'blockId' => 1));

        $siteNetworkArea3 = new Area();
        $siteNetworkArea3->setLabel('Main menu');
        $siteNetworkArea3->setAreaId('main_menu');
        $siteNetworkArea3->addBlock(array('nodeId' => 'root', 'blockId' => 2));

        $siteNetworkArea0 = new Area();
        $siteNetworkArea0->setLabel('Header');
        $siteNetworkArea0->setAreaId('header');
        $siteNetworkArea0->addArea($siteNetworkArea1);
        $siteNetworkArea0->addArea($siteNetworkArea2);
        $siteNetworkArea0->addArea($siteNetworkArea3);

        $siteNetworkArea5 = new Area();
        $siteNetworkArea5->setLabel('Main content area 1');
        $siteNetworkArea5->setAreaId('mainContentArea1');
        $siteNetworkArea5->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteNetworkArea6 = new Area();
        $siteNetworkArea6->setLabel('Module area');
        $siteNetworkArea6->setAreaId('moduleArea');
        $siteNetworkArea6->addBlock(array('nodeId' => 'root', 'blockId' => 6));
        $siteNetworkArea6->addBlock(array('nodeId' => 'root', 'blockId' => 7));

        $siteNetworkArea4 = new Area();
        $siteNetworkArea4->setLabel('My main');
        $siteNetworkArea4->setAreaId('myMain');
        $siteNetworkArea4->addArea($siteNetworkArea5);
        $siteNetworkArea4->addArea($siteNetworkArea6);

        $siteNetworkArea8 = new Area();
        $siteNetworkArea8->setLabel('Containe footer');
        $siteNetworkArea8->setAreaId('containeFooter');
        $siteNetworkArea8->addBlock(array('nodeId' => 'root', 'blockId' => 5));

        $siteNetworkArea7 = new Area();
        $siteNetworkArea7->setLabel('Footer');
        $siteNetworkArea7->setAreaId('footer');
        $siteNetworkArea7->addArea($siteNetworkArea8);

        $siteNetwork = new Node();
        $siteNetwork->setNodeId('fixture_page_networks');
        $siteNetwork->setNodeType('page');
        $siteNetwork->setName('Fixture page networks');
        $siteNetwork->setSiteId('2');
        $siteNetwork->setParentId('root');
        $siteNetwork->setPath('-');
        $siteNetwork->setAlias('page-networks');
        $siteNetwork->setVersion(1);
        $siteNetwork->setLanguage('fr');
        $siteNetwork->setStatus($this->getReference('status-published'));
        $siteNetwork->setDeleted(false);
        $siteNetwork->setTemplateId('');
        $siteNetwork->setTheme('themePresentation');
        $siteNetwork->setInFooter(false);
        $siteNetwork->setInMenu(false);
        $siteNetwork->addArea($siteNetworkArea0);
        $siteNetwork->addArea($siteNetworkArea4);
        $siteNetwork->addArea($siteNetworkArea7);
        $siteNetwork->addBlock($siteNetworkBlock0);

        return $siteNetwork;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteContact()
    {
        $siteContactBlock0 = new Block();
        $siteContactBlock0->setLabel('Wysiwyg');
        $siteContactBlock0->setComponent('tiny_mce_wysiwyg');
        $siteContactBlock0->setAttributes(array(
            "htmlContent" => "<div class='content2' id='contactArea' ><div id='contactInformation'><h3>Contactez-nous</h3><img src='/bundles/fakeapptheme/themes/themePresentation/img/logoOrchestra.png' /><div id='infoInterakting'><p><b>Interakting</b> <br>Groupe Business & Decision<br>153 Rue de Courcelles<br>75017 PARIS FRANCE<br><span class='fontOrange'>Tél:</span> +33 1 56 21 21 21<br> <span class='fontOrange'>Fax:</span> +33 1 56 21 21 22</p></div><div id='accessInterakting'><h3>Accès:</h3> <p><span class='fontOrange'>Metro ligne 3</span> arrêt Pereire<br><span class='fontOrange'>RER ligne C</span> arrêt Pereire-Levallois</p> </div><div id='googleMapsInterakting'><iframe width='425' height='350' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://maps.google.fr/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=153+Rue+de+Courcelles+75817+Paris&amp;aq=&amp;sll=48.834414,2.499298&amp;sspn=0.523838,0.909805&amp;ie=UTF8&amp;hq=&amp;hnear=153+Rue+de+Courcelles,+75817+Paris&amp;ll=48.883747,2.298345&amp;spn=0.004088,0.007108&amp;t=m&amp;z=14&amp;output=embed'></iframe><br /><small><a href='https://maps.google.fr/maps?f=q&amp;source=embed&amp;hl=fr&amp;geocode=&amp;q=153+Rue+de+Courcelles+75817+Paris&amp;aq=&amp;sll=48.834414,2.499298&amp;sspn=0.523838,0.909805&amp;ie=UTF8&amp;hq=&amp;hnear=153+Rue+de+Courcelles,+75817+Paris&amp;ll=48.883747,2.298345&amp;spn=0.004088,0.007108&amp;t=m&amp;z=14' style='color:#0000FF;text-align:left'>Agrandir le plan</a></small></div></div><div id='contactForm'><h3>Une Demande ?<table border='0'><tbody><tr><td valign='top'> Nom </td><td> <input type='text' placeholder='Votre nom' required/> </td></tr><tr> <td valign='top'> Société </td><td> <input type='text' placeholder='Votre société'/> </td></tr><tr><td valign='top'> Email  </td><td> <input type='email' placeholder='Votre e-mail' required/> </td></tr><tr> <td valign='top'> Téléphone </td><td> <input type='tel' placeholder='Votre téléphone' required/></tr><tr><td valign='top'> Sujet   </td><td> <input type='text' placeholder='Votre sujet' required/> </td></tr><tr> <td valign='top'> Type de demande   </td><td> <select><option> Orchestra </option><option> Presse </option><option> Information </option><option> Emploi </option></select></td></tr><tr><td valign='top'> Message </td><td> <textarea  rows='10' cols='25' placeholder='Votre message' required> </textarea> </td></tr> <tr> <td> <input type='submit' value='OK' /></td> </tr> </tbody></table></div></div>",
        ));
        $siteContactBlock0->addArea(array('nodeId' => 0, 'areaId' => 'mainContentArea1'));

        $siteContactArea1 = new Area();
        $siteContactArea1->setLabel('Logo');
        $siteContactArea1->setAreaId('logo');
        $siteContactArea1->addBlock(array('nodeId' => 'root', 'blockId' => 0));

        $siteContactArea2 = new Area();
        $siteContactArea2->setLabel('Sub menu');
        $siteContactArea2->setAreaId('sub_menu');
        $siteContactArea2->addBlock(array('nodeId' => 'root', 'blockId' => 1));

        $siteContactArea3 = new Area();
        $siteContactArea3->setLabel('Main menu');
        $siteContactArea3->setAreaId('main_menu');
        $siteContactArea3->addBlock(array('nodeId' => 'root', 'blockId' => 2));

        $siteContactArea0 = new Area();
        $siteContactArea0->setLabel('Header');
        $siteContactArea0->setAreaId('header');
        $siteContactArea0->addArea($siteContactArea1);
        $siteContactArea0->addArea($siteContactArea2);
        $siteContactArea0->addArea($siteContactArea3);

        $siteContactArea5 = new Area();
        $siteContactArea5->setLabel('Main content area 1');
        $siteContactArea5->setAreaId('mainContentArea1');
        $siteContactArea5->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteContactArea4 = new Area();
        $siteContactArea4->setLabel('My main');
        $siteContactArea4->setAreaId('myMain');
        $siteContactArea4->addArea($siteContactArea5);

        $siteContactArea8 = new Area();
        $siteContactArea8->setLabel('Containe footer');
        $siteContactArea8->setAreaId('containeFooter');
        $siteContactArea8->addBlock(array('nodeId' => 'root', 'blockId' => 5));

        $siteContactArea7 = new Area();
        $siteContactArea7->setLAbel('Footer');
        $siteContactArea7->setAreaId('footer');
        $siteContactArea7->addArea($siteContactArea8);

        $siteContact = new Node();
        $siteContact->setNodeId('fixture_page_contact');
        $siteContact->setNodeType('page');
        $siteContact->setName('Contact');
        $siteContact->setSiteId('2');
        $siteContact->setParentId('root');
        $siteContact->setPath('-');
        $siteContact->setAlias('page-contact');
        $siteContact->setVersion(1);
        $siteContact->setLanguage('fr');
        $siteContact->setStatus($this->getReference('status-published'));
        $siteContact->setDeleted(false);
        $siteContact->setTemplateId('');
        $siteContact->setTheme('themePresentation');
        $siteContact->setInFooter(false);
        $siteContact->setInMenu(true);
        $siteContact->addArea($siteContactArea0);
        $siteContact->addArea($siteContactArea4);
        $siteContact->addArea($siteContactArea7);
        $siteContact->addBlock($siteContactBlock0);

        return $siteContact;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteLegalMentions()
    {
        $siteLegalBlock0 = new Block();
        $siteLegalBlock0->setLabel('Wysiwyg 1');
        $siteLegalBlock0->setComponent('tiny_mce_wysiwyg');
        $siteLegalBlock0->setAttributes(array(
            "htmlContent" => "<div class='content2'> <h1><p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia neque sed consequat dapibus. Nulla hendrerit mollis nisi vitae vehicula. Maecenas viverra lacus neque, quis viverra ligula dignissim vel. Nulla interdum pulvinar vulputate. Cras at urna sem. Nullam sed risus porta, placerat metus bibendum, commodo metus. Donec blandit leo eros, sed convallis odio sollicitudin at.Morbi ut pulvinar lorem. Duis venenatis interdum hendrerit. Curabitur sit amet eleifend sapien. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse volutpat nulla sed eleifend malesuada. Suspendisse fringilla, est et dapibus molestie, orci leo pretium nulla, vitae consectetur ipsum enim ut magna. Duis sagittis auctor sollicitudin. Nunc interdum, quam id varius interdum, nulla felis blandit sapien, ac egestas lectus turpis in urna. Sed id ullamcorper nulla, quis tempor libero. Donec aliquet neque vitae rhoncus vestibulum. Aliquam id nunc ut justo sagittis bibendum sit amet non metus.Mauris aliquam mattis sem, in tempus eros feugiat non. Aenean vitae odio sapien. Curabitur ut luctus purus, nec vehicula nunc. Sed massa odio, sagittis a odio eget, posuere imperdiet eros. Sed sit amet neque tempus urna rutrum egestas. Maecenas dignissim justo orci, vitae aliquet mi gravida feugiat. Quisque ullamcorper non dui eget fringilla. convallis condimentum placerat. Mauris bibendum libero ac neque tempus, et pharetra enim cursus. In nec porta mi. Duis feugiat, enim nec ornare malesuada, ligula metus iaculis quam, dapibus fermentum lacus lorem ut diam. Pellentesque condimentum ante sed augue pretium placerat. Ut venenatis, lacus vel imperdiet aliquam, enim risus rhoncus mi, eget consequat tellus ante nec felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur in erat eget leo tincidunt euismod. Sed hendrerit malesuada magna commodo porta. Suspendisse diam urna, pretium ut mi vel, vulputate ultricies dolor. Nam eleifend accumsan nibh. Duis hendrerit ornare urna, sit amet commodo eros imperdiet nec.Donec tristique est sit amet justo fringilla, a hendrerit ligula ultricies. Phasellus dignissim mi sit amet nibh gravida, vitae lobortis lorem imperdiet. Praesent dolor quam, luctus sed dui eu, eleifend mattis tortor. Curabitur varius lacus at sapien eleifend, vitae feugiat lectus mattis. In malesuada molestie turpis, et mattis ante euismod sed. Integer interdum adipiscing purus vitae vestibulum. Proin aliquam egestas nunc, ut dictum justo lacinia quis. Phasellus tincidunt mauris fringilla mauris hendrerit euismod.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia neque sed consequat dapibus. Nulla hendrerit mollis nisi vitae vehicula. Maecenas viverra lacus neque, quis viverra ligula dignissim vel. Nulla interdum pulvinar vulputate.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia neque sed consequat dapibus. Nulla hendrerit mollis nisi vitae vehicula. Maecenas viverra lacus neque, quis viverra ligula dignissim vel. Nulla interdum pulvinar vulputate.</p></h1></div>",
        ));
        $siteLegalBlock0->addArea(array('nodeId' => 0, 'areaId' => 'mainContentArea1'));

        $siteLegalBlock1 = new Block();
        $siteLegalBlock1->setLabel('Wysiwyg 2');
        $siteLegalBlock1->setComponent('tiny_mce_wysiwyg');
        $siteLegalBlock1->setAttributes(array(
            "htmlContent" => "<div class='content3'>  <h3 class='blocTitle'><p class='titleModule'>Actu</p> </h3>   <div class='blockContent'> NEWS</div> </div>",
        ));
        $siteLegalBlock1->addArea(array('nodeId' => 0, 'areaId' => 'moduleArea'));

        $siteLegalArea1 = new Area();
        $siteLegalArea1->setLabel('Logo');
        $siteLegalArea1->setAreaId('logo');
        $siteLegalArea1->addBlock(array('nodeId' => 'root', 'blockId' => 0));

        $siteLegalArea2 = new Area();
        $siteLegalArea2->setLabel('Sub menu');
        $siteLegalArea2->setAreaId('sub_menu');
        $siteLegalArea2->addBlock(array('nodeId' => 'root', 'blockId' => 1));

        $siteLegalArea3 = new Area();
        $siteLegalArea3->setLabel('Main menu');
        $siteLegalArea3->setAreaId('main_menu');
        $siteLegalArea3->addBlock(array('nodeId' => 'root', 'blockId' => 2));

        $siteLegalArea0 = new Area();
        $siteLegalArea0->setLabel('Header');
        $siteLegalArea0->setAreaId('header');
        $siteLegalArea0->addArea($siteLegalArea1);
        $siteLegalArea0->addArea($siteLegalArea2);
        $siteLegalArea0->addArea($siteLegalArea3);

        $siteLegalArea5 = new Area();
        $siteLegalArea5->setLabel('Main content area 1');
        $siteLegalArea5->setAreaId('mainContentArea1');
        $siteLegalArea5->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteLegalArea6 = new Area();
        $siteLegalArea6->setLabel('Module area');
        $siteLegalArea6->setAreaId('moduleArea');
        $siteLegalArea6->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteLegalArea4 = new Area();
        $siteLegalArea4->setLabel('My main');
        $siteLegalArea4->setAreaId('myMain');
        $siteLegalArea4->addArea($siteLegalArea5);
        $siteLegalArea4->addArea($siteLegalArea6);

        $siteLegalArea8 = new Area();
        $siteLegalArea8->setLabel('Containe footer');
        $siteLegalArea8->setAreaId('containeFooter');
        $siteLegalArea8->addBlock(array('nodeId' => 'root', 'blockId' => 5));

        $siteLegalArea7 = new Area();
        $siteLegalArea7->setLabel('Footer');
        $siteLegalArea7->setAreaId('footer');
        $siteLegalArea7->addArea($siteLegalArea8);

        $siteLegal = new Node();
        $siteLegal->setNodeId('fixture_page_legal_mentions');
        $siteLegal->setNodeType('page');
        $siteLegal->setName('Fixture page legal mentions');
        $siteLegal->setSiteId('2');
        $siteLegal->setParentId('root');
        $siteLegal->setPath('-');
        $siteLegal->setAlias('page legal mentions');
        $siteLegal->setVersion(1);
        $siteLegal->setLanguage('fr');
        $siteLegal->setStatus($this->getReference('status-published'));
        $siteLegal->setDeleted(false);
        $siteLegal->setTemplateId('');
        $siteLegal->setTheme('themePresentation');
        $siteLegal->setInFooter(false);
        $siteLegal->setInMenu(false);
        $siteLegal->addArea($siteLegalArea0);
        $siteLegal->addArea($siteLegalArea4);
        $siteLegal->addArea($siteLegalArea7);
        $siteLegal->addBlock($siteLegalBlock0);
        $siteLegal->addBlock($siteLegalBlock1);

        return $siteLegal;
    }
}
