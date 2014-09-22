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
    function getOrder()
    {
        return 50;
    }

    /**
     * @return Node
     */
    protected function generateNodeHome()
    {
        $homeBlock = new Block();
        $homeBlock->setComponent('sample');
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
        $home->setName('Fixture Home');
        $home->setVersion(1);
        $home->setLanguage('fr');
        $home->setStatus($this->getReference('status-published'));
        $home->setDeleted(false);
        $home->setTemplateId('template_main');
        $home->setTheme('theme1');
        $home->setInMenu(false);
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
        $block0->setComponent('sample');
        $block0->setAttributes(array(
            'title' => 'Qui sommes-nous?',
            'author' => 'Pourquoi nous choisir ?',
            'news' => 'Nos agences'
        ));

        $block1 = new Block();
        $block1->setComponent('menu');
        $block1->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'idmenu',
        ));

        $block2 = new Block();
        $block2->setComponent('sample');
        $block2->setAttributes(array(
            "title" => "News 1",
            "author" => "Donec bibendum at nibh eget imperdiet. Mauris eget justo augue. Fusce fermentum iaculis erat, sollicitudin elementum enim sodales eu. Donec a ante tortor. Suspendisse a.",
            "news" => ""
        ));

        $block3 = new Block();
        $block3->setComponent('sample');
        $block3->setAttributes(array(
            "title" => "News #2",
            "author" => "Aliquam convallis facilisis nulla, id ultricies ipsum cursus eu. Proin augue quam, iaculis id nisi ac, rutrum blandit leo. In leo ante, scelerisque tempus lacinia in, sollicitudin quis justo. Vestibulum.",
            "news" => ""
        ));

        $block4 = new Block();
        $block4->setComponent('sample');
        $block4->setAttributes(array(
            "title" => "News #3",
            "author" => "Phasellus condimentum diam placerat varius iaculis. Aenean dictum, libero in sollicitudin hendrerit, nulla mi elementum massa, eget mattis lorem enim vel magna. Fusce suscipit orci vitae vestibulum.",
            "news" => ""
        ));

        $block5 = new Block();
        $block5->setComponent('sample');
        $block5->setAttributes(array(
            'title' => '/apple-touch-icon.png',
            'author' => 'bépo',
            'news' => '',
            'image' => '/apple-touch-icon.png'
        ));

        $block6 = new Block();
        $block6->setComponent('footer');
        $block6->setAttributes(array(
            'id' => 'idFooter',
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            )
        ));

        $block7 = new Block();
        $block7->setComponent('search');
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
        $mainArea->addArea($leftMenuArea);
        $mainArea->addArea($contentArea);
        $mainArea->addArea($skycrapperArea);

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
        $full->setStatus($this->getReference('status-published'));
        $full->setDeleted(false);
        $full->setTemplateId('template_full');
        $full->setTheme('mixed');
        $full->setInMenu(false);
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
        $aboutUsBlock->setComponent('sample');
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
        $aboutUs->setStatus($this->getReference('status-published'));
        $aboutUs->setDeleted(false);
        $aboutUs->setTemplateId('template_main');
        $aboutUs->setTheme('theme2');
        $aboutUs->setInFooter(true);
        $aboutUs->setInMenu(false);
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
        $bdBlock->setComponent('sample');
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
        $bd->setStatus($this->getReference('status-published'));
        $bd->setDeleted(false);
        $bd->setTemplateId('template_main');
        $bd->setTheme('theme2');
        $bd->setInFooter(true);
        $bd->setInMenu(false);
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
        $interaktingBlock->setComponent('sample');
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
        $interakting->setStatus($this->getReference('status-published'));
        $interakting->setDeleted(false);
        $interakting->setTemplateId('template_main');
        $interakting->setTheme('sample');
        $interakting->setInFooter(true);
        $interakting->setInMenu(false);
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
        $contactUsBlock->setComponent('sample');
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
        $contactUs->setStatus($this->getReference('status-published'));
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
        $directoryBlock->setComponent('sample');
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
        $directory->setStatus($this->getReference('status-published'));
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
        $searchBlock0->setComponent('sample');
        $searchBlock0->setAttributes(array(
            'title' => 'Qui somme-nous?',
            'author' => 'Pourquoi nous choisir ?',
            'news' => 'Nos agences'
        ));

        $searchBlock1 = new Block();
        $searchBlock1->setComponent('menu');
        $searchBlock1->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'idmenu',
        ));

        $searchBlock2 = new Block();
        $searchBlock2->setComponent('search');
        $searchBlock2->setAttributes(array(
            'value' => 'Rechercher',
            'name' => "btnSearch",
            'class' => 'classbouton',
            'nodeId' => 'fixture_search'
        ));

        $searchBlock3 = new Block();
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

        $searchBlock4 = new Block();
        $searchBlock4->setComponent('footer');
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
        $searchArea1->addArea($leftMenuArea);
        $searchArea1->addArea($contentArea);


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
        $search->setStatus($this->getReference('status-published'));
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

    /**
     * @return Node
     */
    public function generateNodeSiteHome()
    {
        $siteHomeBlock0 = new Block();
        $siteHomeBlock0->setComponent('tiny_mce_wysiwyg');
        $siteHomeBlock0->setAttributes(array(
            "_htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themeAyman/img/logoOrchestra.png' /> </a>",
        ));

        $siteHomeBlock1 = new Block();
        $siteHomeBlock1->setComponent('tiny_mce_wysiwyg');
        $siteHomeBlock1->setAttributes(array(
            "_htmlContent" => "<ul id='mySubMenu'> <li><a href='/app_dev.php/node/fixture_page_about_us'> A PROPOS </a></li> <li><a href='/app_dev.php/node/fixture_page_our_team'> NOTRE EQUIPE </a></li><li><a href='/app_dev.php/node/fixture_page_news'> NOTRE ACTU </a></li><li><a href='/app_dev.php/node/fixture_page_join_us'>  NOUS REJOINDRE</a></li> <li><a href='/app_dev.php/node/fixture_page_networks'> NETWORKS </a></li> </ul>",
        ));

        $siteHomeBlockMenu = new Block();
        $siteHomeBlockMenu->setComponent('menu');
        $siteHomeBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));

        $siteHomeCarrousel = new Block();
        $siteHomeCarrousel->setComponent('carrousel');
        $siteHomeCarrousel->setAttributes(array(
            'pictures' => array(
                array('src' => "/bundles/fakeapptheme/themes/themeAyman/img/carroussel/02.jpg"),
                array('src' => "/bundles/fakeapptheme/themes/themeAyman/img/carroussel/03.jpg"),
                array('src' => "/bundles/fakeapptheme/themes/themeAyman/img/carroussel/04.jpg"),
                array('src' => "/bundles/fakeapptheme/themes/themeAyman/img/carroussel/05.jpg"),
            ),
            'width' => "600px",
            'height' => "300px",
        ));

        $siteHomeBlock4 = new Block();
        $siteHomeBlock4->setComponent('tiny_mce_wysiwyg');
        $siteHomeBlock4->setAttributes(array(
            "_htmlContent" => "<div id='area2.2' class='content'><p>
            Business & Decision est un Groupe international de services numériques,  leader de la Business Intelligence (BI) et du CRM, acteur majeur de l'e-Business.  Le Groupe contribue à la réussite des projets à forte valeur ajoutée des entreprises et accompagne ses clients dans des domaines d’innovation tels que le Big Data et le Digital. Il est reconnu pour son expertise fonctionnelle et technologique par les plus grands éditeurs de logiciels du marché avec lesquels il a noué des partenariats. Fort d’une expertise unique dans ses domaines de spécialisation, Business & Decision offre des solutions adaptées à des secteurs d’activité ainsi qu’à des directions métiers.
            </p></div>",
        ));

        $siteHomeBlock5 = new Block();
        $siteHomeBlock5->setComponent('tiny_mce_wysiwyg');
        $siteHomeBlock5->setAttributes(array(
            "_htmlContent" => "<div id='footerInfos'><h4>Infos</h4><ul><li> <a href=''>Qui sommes nous ?</a> </li><li> <a href=''>Contact</a> </li></ul></div> <div id='footerLegal'><h4>Légal</h4><ul><li> <a href=''>Mentions Légal</a> </li><li> <a href=''>Plan du site</a> </li></ul></div> <div id='footerNetworks'><h4>Networks</h4><ul><li> <a href='http://www.businessdecision.fr/'>http://www.businessdecision.fr/</a> </li><li> <a href='http://www.interakting.com/'>http://www.interakting.com/</a> </li></ul></div> <div id='footerContact'><h4>Contact</h4> <ul> <li>Interakting</li><li>153 Rue de Courcelles</li> <li>75017 Paris France</li> <li>01 56 21 21 21</li><li> <a href='#'>contact@interakting.com </a> </li></div>",
        ));

        $siteHomeArea1 = new Area();
        $siteHomeArea1->setAreaId('logo');
        $siteHomeArea1->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteHomeArea2 = new Area();
        $siteHomeArea2->setAreaId('sub_menu');
        $siteHomeArea2->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteHomeArea3 = new Area();
        $siteHomeArea3->setAreaId('main_menu');
        $siteHomeArea3->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteHomeArea0 = new Area();
        $siteHomeArea0->setAreaId('header');
        $siteHomeArea0->addArea($siteHomeArea1);
        $siteHomeArea0->addArea($siteHomeArea2);
        $siteHomeArea0->addArea($siteHomeArea3);

        $siteHomeArea5 = new Area();
        $siteHomeArea5->setAreaId('mainContentCarrousel');
        $siteHomeArea5->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteHomeArea6 = new Area();
        $siteHomeArea6->setAreaId('mainContentArea2');
        $siteHomeArea6->addBlock(array('nodeId' => 0, 'blockId' => 4));

        $siteHomeArea4 = new Area();
        $siteHomeArea4->setAreaId('myMain');
        $siteHomeArea4->addArea($siteHomeArea5);
        $siteHomeArea4->addArea($siteHomeArea6);

        $siteHomeFooter = new Area();
        $siteHomeFooter->setAreaId('containeFooter');
        $siteHomeFooter->addBlock(array('nodeId' => 0, 'blockId' => 5));

        $siteHomeContainerFooter = new Area();
        $siteHomeContainerFooter->setAreaId('footer');
        $siteHomeContainerFooter->addArea($siteHomeFooter);

        $siteHome = new Node();
        $siteHome->setNodeId('fixture_page_home');
        $siteHome->setNodeType('page');
        $siteHome->setName('Home');
        $siteHome->setSiteId(2);
        $siteHome->setParentId('root');
        $siteHome->setPath('-');
        $siteHome->setAlias('page-home');
        $siteHome->setVersion(1);
        $siteHome->setLanguage('fr');
        $siteHome->setStatus($this->getReference('status-published'));
        $siteHome->setDeleted(false);
        $siteHome->setTemplateId('');
        $siteHome->setTheme('themeAyman');
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

        return $siteHome;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteWhatIsOrchestra()
    {
        $siteWhatBlock0 = new Block();
        $siteWhatBlock0->setComponent('tiny_mce_wysiwyg');
        $siteWhatBlock0->setAttributes(array(
            "_htmlContent" => "",
        ));

        $siteWhatBlock1 = new Block();
        $siteWhatBlock1->setComponent('tiny_mce_wysiwyg');
        $siteWhatBlock1->setAttributes(array(
            "_htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themeAyman/img/logoOrchestra.png' /> </a>",
        ));

        $siteWhatBlock2 = new Block();
        $siteWhatBlock2->setComponent('tiny_mce_wysiwyg');
        $siteWhatBlock2->setAttributes(array(
            "_htmlContent" => "<ul id='mySubMenu'> <li><a href='/app_dev.php/node/fixture_page_about_us'> A PROPOS </a></li> <li><a href='/app_dev.php/node/fixture_page_our_team'> NOTRE EQUIPE </a></li><li><a href='/app_dev.php/node/fixture_page_news'> NOTRE ACTU </a></li><li><a href='/app_dev.php/node/fixture_page_join_us'>  NOUS REJOINDRE</a></li> <li><a href='/app_dev.php/node/fixture_page_networks'> NETWORKS </a></li> </ul>",
        ));

        $siteWhatBlockMenu = new Block();
        $siteWhatBlockMenu->setComponent('menu');
        $siteWhatBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));

        $siteWhatBlock4 = new Block();
        $siteWhatBlock4->setComponent('tiny_mce_wysiwyg');
        $siteWhatBlock4->setAttributes(array(
            "_htmlContent" => "<div class='content2'> <h1><p>
PHP Factory est une plateforme développée conjointement par Interakting et Zend Technologies. Cette offre, dédiée au marketing est destinée aux grands projets de nouvelle génération en digital marketing et entreprise 2.0.

L’objectif de PHP Factory est de répondre aux exigences les plus élevées des grands comptes en termes de haute disponibilité, de performance et d'industrialisation des processus de création et de diffusion de contenus vers le Web et les mobiles.

Elle a été développé  autour des standards PHP de Zend. Elle est constituée d’une bibliothèque de composants : gestion de contenu web et multi-média, d’e-commerce, d’animation de réseaux sociaux, de Portail et de Mobilité.
               </p></h1></div>",
        ));

        $siteWhatBlock5 = new Block();
        $siteWhatBlock5->setComponent('tiny_mce_wysiwyg');
        $siteWhatBlock5->setAttributes(array(
            "_htmlContent" => "<div class='content3'>  <h3 class='blocTitle'><p class='titleModule'>Actu</p> </h3>   <div class='blockContent'> NEWS</div> </div>",
        ));

        $siteWhatBlock6 = new Block();
        $siteWhatBlock6->setComponent('contact');
        $siteWhatBlock6->setAttributes(array(
            "id" => "myFormContact",
            "class" => "myFormContact",
        ));

        $siteWhatBlock7 = new Block();
        $siteWhatBlock7->setComponent('tiny_mce_wysiwyg');
        $siteWhatBlock7->setAttributes(array(
            "_htmlContent" => "<div id='footerInfos'><h4>Infos</h4><ul><li> <a href=''>Qui sommes nous ?</a> </li><li> <a href=''>Contact</a> </li></ul></div> <div id='footerLegal'><h4>Légal</h4><ul><li> <a href=''>Mentions Légal</a> </li><li> <a href=''>Plan du site</a> </li></ul></div> <div id='footerNetworks'><h4>Networks</h4><ul><li> <a href='http://www.businessdecision.fr/'>http://www.businessdecision.fr/</a> </li><li> <a href='http://www.interakting.com/'>http://www.interakting.com/</a> </li></ul></div> <div id='footerContact'><h4>Contact</h4> <ul> <li>Interakting</li><li>153 Rue de Courcelles</li> <li>75017 Paris France</li> <li>01 56 21 21 21</li><li> <a href='#'>contact@interakting.com</a> </li></div>",
        ));

        $siteWhatArea1 = new Area();
        $siteWhatArea1->setAreaId('logo');
        $siteWhatArea1->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteWhatArea2 = new Area();
        $siteWhatArea2->setAreaId('sub_menu');
        $siteWhatArea2->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteWhatArea3 = new Area();
        $siteWhatArea3->setAreaId('main_menu');
        $siteWhatArea3->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteWhatArea0 = new Area();
        $siteWhatArea0->setAreaId('header');
        $siteWhatArea0->addArea($siteWhatArea1);
        $siteWhatArea0->addArea($siteWhatArea2);
        $siteWhatArea0->addArea($siteWhatArea3);

        $siteWhatArea5 = new Area();
        $siteWhatArea5->setAreaId('mainContentArea1');
        $siteWhatArea5->addBlock(array('nodeId' => 0, 'blockId' => 4));

        $siteWhatArea6 = new Area();
        $siteWhatArea6->setAreaId('moduleArea');
        $siteWhatArea6->addBlock(array('nodeId' => 0, 'blockId' => 5));
        $siteWhatArea6->addBlock(array('nodeId' => 0, 'blockId' => 6));

        $siteWhatArea4 = new Area();
        $siteWhatArea4->setAreaId('myMain');
        $siteWhatArea4->addArea($siteWhatArea5);
        $siteWhatArea4->addArea($siteWhatArea6);

        $siteWhatArea8 = new Area();
        $siteWhatArea8->setAreaId('containeFooter');
        $siteWhatArea8->addBlock(array('nodeId' => 0, 'blockId' => 7));

        $siteWhatArea7 = new Area();
        $siteWhatArea7->setAreaId('footer');
        $siteWhatArea7->addArea($siteWhatArea8);

        $siteWhat = new Node();
        $siteWhat->setNodeId('fixture_page_what_is_orchestra');
        $siteWhat->setNodeType('page');
        $siteWhat->setName('Orchestra ?');
        $siteWhat->setSiteId(2);
        $siteWhat->setParentId('fixture_page_home');
        $siteWhat->setPath('-');
        $siteWhat->setAlias('page-what-is-orchestra');
        $siteWhat->setVersion(1);
        $siteWhat->setLanguage('fr');
        $siteWhat->setStatus($this->getReference('status-published'));
        $siteWhat->setDeleted(false);
        $siteWhat->setTemplateId('');
        $siteWhat->setTheme('themeAyman');
        $siteWhat->setInFooter(false);
        $siteWhat->setInMenu(true);
        $siteWhat->addArea($siteWhatArea0);
        $siteWhat->addArea($siteWhatArea4);
        $siteWhat->addArea($siteWhatArea7);
        $siteWhat->addBlock($siteWhatBlock0);
        $siteWhat->addBlock($siteWhatBlock1);
        $siteWhat->addBlock($siteWhatBlock2);
        $siteWhat->addBlock($siteWhatBlockMenu);
        $siteWhat->addBlock($siteWhatBlock4);
        $siteWhat->addBlock($siteWhatBlock5);
        $siteWhat->addBlock($siteWhatBlock6);
        $siteWhat->addBlock($siteWhatBlock7);

        return $siteWhat;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteStartOrchestra()
    {
        $siteStartBlock1 = new Block();
        $siteStartBlock1->setComponent('tiny_mce_wysiwyg');
        $siteStartBlock1->setAttributes(array(
            "_htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themeAyman/img/logoOrchestra.png' /> </a>",
        ));

        $siteStartBlock2 = new Block();
        $siteStartBlock2->setComponent('tiny_mce_wysiwyg');
        $siteStartBlock2->setAttributes(array(
            "_htmlContent" => "<ul id='mySubMenu'> <li><a href='/app_dev.php/node/fixture_page_about_us'> A PROPOS </a></li> <li><a href='/app_dev.php/node/fixture_page_our_team'> NOTRE EQUIPE </a></li><li><a href='/app_dev.php/node/fixture_page_news'> NOTRE ACTU </a></li><li><a href='/app_dev.php/node/fixture_page_join_us'>  NOUS REJOINDRE</a></li> <li><a href='/app_dev.php/node/fixture_page_networks'> NETWORKS </a></li> </ul>",
        ));

        $siteStartBlockMenu = new Block();
        $siteStartBlockMenu->setComponent('menu');
        $siteStartBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));

        $siteStartBlock4 = new Block();
        $siteStartBlock4->setComponent('tiny_mce_wysiwyg');
        $siteStartBlock4->setAttributes(array(
            "_htmlContent" => "<div class='content2'> <h1>Area1</h1></div>",
        ));

        $siteStartBlock5 = new Block();
        $siteStartBlock5->setComponent('tiny_mce_wysiwyg');
        $siteStartBlock5->setAttributes(array(
            "_htmlContent" => "<div class='content3'>  <h3 class='blocTitle'><p class='titleModule'>Actu</p> </h3>   <div class='blockContent'> NEWS</div> </div>",
        ));

        $siteStartBlock6 = new Block();
        $siteStartBlock6->setComponent('contact');
        $siteStartBlock6->setAttributes(array(
            "id" => "myFormContact",
            "class" => "myFormContact",
        ));

        $siteStartBlock7 = new Block();
        $siteStartBlock7->setComponent('tiny_mce_wysiwyg');
        $siteStartBlock7->setAttributes(array(
            "_htmlContent" => "<div id='footerInfos'><h4>Infos</h4><ul><li> <a href=''>Qui sommes nous ?</a> </li><li> <a href=''>Contact</a> </li></ul></div> <div id='footerLegal'><h4>Légal</h4><ul><li> <a href=''>Mentions Légal</a> </li><li> <a href=''>Plan du site</a> </li></ul></div> <div id='footerNetworks'><h4>Networks</h4><ul><li> <a href='http://www.businessdecision.fr/'>http://www.businessdecision.fr/</a> </li><li> <a href='http://www.interakting.com/'>http://www.interakting.com/</a> </li></ul></div> <div id='footerContact'><h4>Contact</h4> <ul> <li>Interakting</li><li>153 Rue de Courcelles</li> <li>75017 Paris France</li> <li>01 56 21 21 21</li><li> <a href='#'>contact@interakting.com</a> </li></div>",
        ));

        $siteStartArea1 = new Area();
        $siteStartArea1->setAreaId('logo');
        $siteStartArea1->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteStartArea2 = new Area();
        $siteStartArea2->setAreaId('sub_menu');
        $siteStartArea2->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteStartArea3 = new Area();
        $siteStartArea3->setAreaId('main_menu');
        $siteStartArea3->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteStartArea0 = new Area();
        $siteStartArea0->setAreaId('header');
        $siteStartArea0->addArea($siteStartArea1);
        $siteStartArea0->addArea($siteStartArea2);
        $siteStartArea0->addArea($siteStartArea3);

        $siteStartArea5 = new Area();
        $siteStartArea5->setAreaId('mainContentArea1');
        $siteStartArea5->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteStartArea6 = new Area();
        $siteStartArea6->setAreaId('moduleArea');
        $siteStartArea6->addBlock(array('nodeId' => 0, 'blockId' => 4));
        $siteStartArea6->addBlock(array('nodeId' => 0, 'blockId' => 5));

        $siteStartArea4 = new Area();
        $siteStartArea4->setAreaId('myMain');
        $siteStartArea4->addArea($siteStartArea5);
        $siteStartArea4->addArea($siteStartArea6);

        $siteStartArea8 = new Area();
        $siteStartArea8->setAreaId('containeFooter');
        $siteStartArea8->addBlock(array('nodeId' => 0, 'blockId' => 6));

        $siteStartArea7 = new Area();
        $siteStartArea7->setAreaId('footer');
        $siteStartArea7->addArea($siteStartArea8);

        $siteStart = new Node();
        $siteStart->setNodeId('fixture_page_start_orchestra');
        $siteStart->setNodeType('page');
        $siteStart->setName('Get Started');
        $siteStart->setSiteId(2);
        $siteStart->setParentId('fixture_page_home');
        $siteStart->setPath('-');
        $siteStart->setAlias('page-start-orchestra');
        $siteStart->setVersion(1);
        $siteStart->setLanguage('fr');
        $siteStart->setStatus($this->getReference('status-published'));
        $siteStart->setDeleted(false);
        $siteStart->setTemplateId('');
        $siteStart->setTheme('themeAyman');
        $siteStart->setInFooter(false);
        $siteStart->setInMenu(true);
        $siteStart->addArea($siteStartArea0);
        $siteStart->addArea($siteStartArea4);
        $siteStart->addArea($siteStartArea7);
        $siteStart->addBlock($siteStartBlock1);
        $siteStart->addBlock($siteStartBlock2);
        $siteStart->addBlock($siteStartBlockMenu);
        $siteStart->addBlock($siteStartBlock4);
        $siteStart->addBlock($siteStartBlock5);
        $siteStart->addBlock($siteStartBlock6);
        $siteStart->addBlock($siteStartBlock7);

        return $siteStart;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteDocumentation()
    {
        $siteDocBlock1 = new Block();
        $siteDocBlock1->setComponent('tiny_mce_wysiwyg');
        $siteDocBlock1->setAttributes(array(
            "_htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themeAyman/img/logoOrchestra.png' /> </a>",
        ));

        $siteDocBlock2 = new Block();
        $siteDocBlock2->setComponent('tiny_mce_wysiwyg');
        $siteDocBlock2->setAttributes(array(
            "_htmlContent" => "<ul id='mySubMenu'> <li><a href='/app_dev.php/node/fixture_page_about_us'> A PROPOS </a></li> <li><a href='/app_dev.php/node/fixture_page_our_team'> NOTRE EQUIPE </a></li><li><a href='/app_dev.php/node/fixture_page_news'> NOTRE ACTU </a></li><li><a href='/app_dev.php/node/fixture_page_join_us'>  NOUS REJOINDRE</a></li> <li><a href='/app_dev.php/node/fixture_page_networks'> NETWORKS </a></li> </ul>",
        ));

        $siteDocBlockMenu = new Block();
        $siteDocBlockMenu->setComponent('menu');
        $siteDocBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));

        $siteDocBlock4 = new Block();
        $siteDocBlock4->setComponent('tiny_mce_wysiwyg');
        $siteDocBlock4->setAttributes(array(
            "_htmlContent" => "<div class='content2'> <h1>Area1</h1></div>",
        ));

        $siteDocBlock5 = new Block();
        $siteDocBlock5->setComponent('tiny_mce_wysiwyg');
        $siteDocBlock5->setAttributes(array(
            "_htmlContent" => "<div class='content3'>  <h3 class='blocTitle'><p class='titleModule'>Actu</p> </h3>   <div class='blockContent'> NEWS</div> </div>",
        ));

        $siteDocBlock6 = new Block();
        $siteDocBlock6->setComponent('contact');
        $siteDocBlock6->setAttributes(array(
            "id" => "myFormContact",
            "class" => "myFormContact",
        ));

        $siteDocBlock7 = new Block();
        $siteDocBlock7->setComponent('tiny_mce_wysiwyg');
        $siteDocBlock7->setAttributes(array(
            "_htmlContent" => "<div id='footerInfos'><h4>Infos</h4><ul><li> <a href=''>Qui sommes nous ?</a> </li><li> <a href=''>Contact</a> </li></ul></div> <div id='footerLegal'><h4>Légal</h4><ul><li> <a href=''>Mentions Légal</a> </li><li> <a href=''>Plan du site</a> </li></ul></div> <div id='footerNetworks'><h4>Networks</h4><ul><li> <a href='http://www.businessdecision.fr/'>http://www.businessdecision.fr/</a> </li><li> <a href='http://www.interakting.com/'>http://www.interakting.com/</a> </li></ul></div> <div id='footerContact'><h4>Contact</h4> <ul> <li>Interakting</li><li>153 Rue de Courcelles</li> <li>75017 Paris France</li> <li>01 56 21 21 21</li><li> <a href='#'>contact@interakting.com</a> </li></div>",
        ));

        $siteDocArea1 = new Area();
        $siteDocArea1->setAreaId('logo');
        $siteDocArea1->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteDocArea2 = new Area();
        $siteDocArea2->setAreaId('sub_menu');
        $siteDocArea2->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteDocArea3 = new Area();
        $siteDocArea3->setAreaId('main_menu');
        $siteDocArea3->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteDocArea0 = new Area();
        $siteDocArea0->setAreaId('header');
        $siteDocArea0->addArea($siteDocArea1);
        $siteDocArea0->addArea($siteDocArea2);
        $siteDocArea0->addArea($siteDocArea3);

        $siteDocArea5 = new Area();
        $siteDocArea5->setAreaId('mainContentArea1');
        $siteDocArea5->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteDocArea6 = new Area();
        $siteDocArea6->setAreaId('moduleArea');
        $siteDocArea6->addBlock(array('nodeId' => 0, 'blockId' => 4));
        $siteDocArea6->addBlock(array('nodeId' => 0, 'blockId' => 5));

        $siteDocArea4 = new Area();
        $siteDocArea4->setAreaId('myMain');
        $siteDocArea4->addArea($siteDocArea5);
        $siteDocArea4->addArea($siteDocArea6);

        $siteDocArea8 = new Area();
        $siteDocArea8->setAreaId('containeFooter');
        $siteDocArea8->addBlock(array('nodeId' => 0, 'blockId' => 6));

        $siteDocArea7 = new Area();
        $siteDocArea7->setAreaId('footer');
        $siteDocArea7->addArea($siteDocArea8);

        $siteDoc = new Node();
        $siteDoc->setNodeId('fixture_page_documentation');
        $siteDoc->setNodeType('page');
        $siteDoc->setName('Documentation');
        $siteDoc->setSiteId(2);
        $siteDoc->setParentId('fixture_page_home');
        $siteDoc->setPath('-');
        $siteDoc->setAlias('page-documentation');
        $siteDoc->setVersion(1);
        $siteDoc->setLanguage('fr');
        $siteDoc->setStatus($this->getReference('status-published'));
        $siteDoc->setDeleted(false);
        $siteDoc->setTemplateId('');
        $siteDoc->setTheme('themeAyman');
        $siteDoc->setInFooter(false);
        $siteDoc->setInMenu(true);
        $siteDoc->addArea($siteDocArea0);
        $siteDoc->addArea($siteDocArea4);
        $siteDoc->addArea($siteDocArea7);
        $siteDoc->addBlock($siteDocBlock1);
        $siteDoc->addBlock($siteDocBlock2);
        $siteDoc->addBlock($siteDocBlockMenu);
        $siteDoc->addBlock($siteDocBlock4);
        $siteDoc->addBlock($siteDocBlock5);
        $siteDoc->addBlock($siteDocBlock6);
        $siteDoc->addBlock($siteDocBlock7);

        return $siteDoc;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteCommunity()
    {
        $siteComBlock1 = new Block();
        $siteComBlock1->setComponent('tiny_mce_wysiwyg');
        $siteComBlock1->setAttributes(array(
            "_htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themeAyman/img/logoOrchestra.png' /> </a>",
        ));

        $siteComBlock2 = new Block();
        $siteComBlock2->setComponent('tiny_mce_wysiwyg');
        $siteComBlock2->setAttributes(array(
            "_htmlContent" => "<ul id='mySubMenu'> <li><a href='/app_dev.php/node/fixture_page_about_us'> A PROPOS </a></li> <li><a href='/app_dev.php/node/fixture_page_our_team'> NOTRE EQUIPE </a></li><li><a href='/app_dev.php/node/fixture_page_news'> NOTRE ACTU </a></li><li><a href='/app_dev.php/node/fixture_page_join_us'>  NOUS REJOINDRE</a></li> <li><a href='/app_dev.php/node/fixture_page_networks'> NETWORKS </a></li> </ul>",
        ));

        $siteComBlockMenu = new Block();
        $siteComBlockMenu->setComponent('menu');
        $siteComBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));

        $siteComBlock4 = new Block();
        $siteComBlock4->setComponent('tiny_mce_wysiwyg');
        $siteComBlock4->setAttributes(array(
            "_htmlContent" => "<div class='content2'> <h1>Area1</h1></div>",
        ));

        $siteComBlock5 = new Block();
        $siteComBlock5->setComponent('tiny_mce_wysiwyg');
        $siteComBlock5->setAttributes(array(
            "_htmlContent" => "<div class='content3'>  <h3 class='blocTitle'><p class='titleModule'>Actu</p> </h3>   <div class='blockContent'> NEWS</div> </div>",
        ));

        $siteComBlock6 = new Block();
        $siteComBlock6->setComponent('contact');
        $siteComBlock6->setAttributes(array(
            "id" => "myFormContact",
            "class" => "myFormContact",
        ));

        $siteComBlock7 = new Block();
        $siteComBlock7->setComponent('tiny_mce_wysiwyg');
        $siteComBlock7->setAttributes(array(
            "_htmlContent" => "<div id='footerInfos'><h4>Infos</h4><ul><li> <a href=''>Qui sommes nous ?</a> </li><li> <a href=''>Contact</a> </li></ul></div> <div id='footerLegal'><h4>Légal</h4><ul><li> <a href=''>Mentions Légal</a> </li><li> <a href=''>Plan du site</a> </li></ul></div> <div id='footerNetworks'><h4>Networks</h4><ul><li> <a href='http://www.businessdecision.fr/'>http://www.businessdecision.fr/</a> </li><li> <a href='http://www.interakting.com/'>http://www.interakting.com/</a> </li></ul></div> <div id='footerContact'><h4>Contact</h4> <ul> <li>Interakting</li><li>153 Rue de Courcelles</li> <li>75017 Paris France</li> <li>01 56 21 21 21</li><li> <a href='#'>contact@interakting.com</a> </li></div>",
        ));

        $siteComArea1 = new Area();
        $siteComArea1->setAreaId('logo');
        $siteComArea1->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteComArea2 = new Area();
        $siteComArea2->setAreaId('sub_menu');
        $siteComArea2->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteComArea3 = new Area();
        $siteComArea3->setAreaId('main_menu');
        $siteComArea3->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteComArea0 = new Area();
        $siteComArea0->setAreaId('header');
        $siteComArea0->addArea($siteComArea1);
        $siteComArea0->addArea($siteComArea2);
        $siteComArea0->addArea($siteComArea3);

        $siteComArea5 = new Area();
        $siteComArea5->setAreaId('mainContentArea1');
        $siteComArea5->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteComArea6 = new Area();
        $siteComArea6->setAreaId('moduleArea');
        $siteComArea6->addBlock(array('nodeId' => 0, 'blockId' => 4));
        $siteComArea6->addBlock(array('nodeId' => 0, 'blockId' => 5));

        $siteComArea4 = new Area();
        $siteComArea4->setAreaId('myMain');
        $siteComArea4->addArea($siteComArea5);
        $siteComArea4->addArea($siteComArea6);

        $siteComArea8 = new Area();
        $siteComArea8->setAreaId('containeFooter');
        $siteComArea8->addBlock(array('nodeId' => 0, 'blockId' => 6));

        $siteComArea7 = new Area();
        $siteComArea7->setAreaId('footer');
        $siteComArea7->addArea($siteComArea8);

        $siteCom = new Node();
        $siteCom->setNodeId('fixture_page_community');
        $siteCom->setNodeType('page');
        $siteCom->setName('Communauté');
        $siteCom->setSiteId(2);
        $siteCom->setParentId('fixture_page_home');
        $siteCom->setPath('-');
        $siteCom->setAlias('page-community');
        $siteCom->setVersion(1);
        $siteCom->setLanguage('fr');
        $siteCom->setStatus($this->getReference('status-published'));
        $siteCom->setDeleted(false);
        $siteCom->setTemplateId('');
        $siteCom->setTheme('themeAyman');
        $siteCom->setInFooter(false);
        $siteCom->setInMenu(true);
        $siteCom->addArea($siteComArea0);
        $siteCom->addArea($siteComArea4);
        $siteCom->addArea($siteComArea7);
        $siteCom->addBlock($siteComBlock1);
        $siteCom->addBlock($siteComBlock2);
        $siteCom->addBlock($siteComBlockMenu);
        $siteCom->addBlock($siteComBlock4);
        $siteCom->addBlock($siteComBlock5);
        $siteCom->addBlock($siteComBlock6);
        $siteCom->addBlock($siteComBlock7);

        return $siteCom;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteAboutUs()
    {
        $siteAboutUsBlock1 = new Block();
        $siteAboutUsBlock1->setComponent('tiny_mce_wysiwyg');
        $siteAboutUsBlock1->setAttributes(array(
            "_htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themeAyman/img/logoOrchestra.png' /> </a>",
        ));

        $siteAboutUsBlock2 = new Block();
        $siteAboutUsBlock2->setComponent('tiny_mce_wysiwyg');
        $siteAboutUsBlock2->setAttributes(array(
            "_htmlContent" => "<ul id='mySubMenu'> <li><a href='/app_dev.php/node/fixture_page_about_us'> A PROPOS </a></li> <li><a href='/app_dev.php/node/fixture_page_our_team'> NOTRE EQUIPE </a></li><li><a href='/app_dev.php/node/fixture_page_news'> NOTRE ACTU </a></li><li><a href='/app_dev.php/node/fixture_page_join_us'>  NOUS REJOINDRE</a></li> <li><a href='/app_dev.php/node/fixture_page_networks'> NETWORKS </a></li> </ul>",
        ));

        $siteAboutUsBlockMenu = new Block();
        $siteAboutUsBlockMenu->setComponent('menu');
        $siteAboutUsBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));

        $siteAboutUsBlock4 = new Block();
        $siteAboutUsBlock4->setComponent('tiny_mce_wysiwyg');
        $siteAboutUsBlock4->setAttributes(array(
            "_htmlContent" => "<div class='content2'> <h1>Area1</h1></div>",
        ));

        $siteAboutUsBlock5 = new Block();
        $siteAboutUsBlock5->setComponent('tiny_mce_wysiwyg');
        $siteAboutUsBlock5->setAttributes(array(
            "_htmlContent" => "<div class='content3'>  <h3 class='blocTitle'><p class='titleModule'>Actu</p> </h3>   <div class='blockContent'> NEWS</div> </div>",
        ));

        $siteAboutUsBlock6 = new Block();
        $siteAboutUsBlock6->setComponent('contact');
        $siteAboutUsBlock6->setAttributes(array(
            "id" => "myFormContact",
            "class" => "myFormContact",
        ));

        $siteAboutUsBlock7 = new Block();
        $siteAboutUsBlock7->setComponent('tiny_mce_wysiwyg');
        $siteAboutUsBlock7->setAttributes(array(
            "_htmlContent" => "<div id='footerInfos'><h4>Infos</h4><ul><li> <a href=''>Qui sommes nous ?</a> </li><li> <a href=''>Contact</a> </li></ul></div> <div id='footerLegal'><h4>Légal</h4><ul><li> <a href=''>Mentions Légal</a> </li><li> <a href=''>Plan du site</a> </li></ul></div> <div id='footerNetworks'><h4>Networks</h4><ul><li> <a href='http://www.businessdecision.fr/'>http://www.businessdecision.fr/</a> </li><li> <a href='http://www.interakting.AboutUs/'>http://www.interakting.AboutUs/</a> </li></ul></div> <div id='footerContact'><h4>Contact</h4> <ul> <li>Interakting</li><li>153 Rue de Courcelles</li> <li>75017 Paris France</li> <li>01 56 21 21 21</li><li> <a href='#'>contact@interakting.AboutUs</a> </li></div>",
        ));

        $siteAboutUsArea1 = new Area();
        $siteAboutUsArea1->setAreaId('logo');
        $siteAboutUsArea1->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteAboutUsArea2 = new Area();
        $siteAboutUsArea2->setAreaId('sub_menu');
        $siteAboutUsArea2->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteAboutUsArea3 = new Area();
        $siteAboutUsArea3->setAreaId('main_menu');
        $siteAboutUsArea3->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteAboutUsArea0 = new Area();
        $siteAboutUsArea0->setAreaId('header');
        $siteAboutUsArea0->addArea($siteAboutUsArea1);
        $siteAboutUsArea0->addArea($siteAboutUsArea2);
        $siteAboutUsArea0->addArea($siteAboutUsArea3);

        $siteAboutUsArea5 = new Area();
        $siteAboutUsArea5->setAreaId('mainContentArea1');
        $siteAboutUsArea5->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteAboutUsArea6 = new Area();
        $siteAboutUsArea6->setAreaId('moduleArea');
        $siteAboutUsArea6->addBlock(array('nodeId' => 0, 'blockId' => 4));
        $siteAboutUsArea6->addBlock(array('nodeId' => 0, 'blockId' => 5));

        $siteAboutUsArea4 = new Area();
        $siteAboutUsArea4->setAreaId('myMain');
        $siteAboutUsArea4->addArea($siteAboutUsArea5);
        $siteAboutUsArea4->addArea($siteAboutUsArea6);

        $siteAboutUsArea8 = new Area();
        $siteAboutUsArea8->setAreaId('containeFooter');
        $siteAboutUsArea8->addBlock(array('nodeId' => 0, 'blockId' => 6));

        $siteAboutUsArea7 = new Area();
        $siteAboutUsArea7->setAreaId('footer');
        $siteAboutUsArea7->addArea($siteAboutUsArea8);

        $siteAboutUs = new Node();
        $siteAboutUs->setNodeId('fixture_page_about_us');
        $siteAboutUs->setNodeType('page');
        $siteAboutUs->setName('A propos');
        $siteAboutUs->setSiteId(2);
        $siteAboutUs->setParentId('fixture_page_home');
        $siteAboutUs->setPath('-');
        $siteAboutUs->setAlias('page-about-us');
        $siteAboutUs->setVersion(1);
        $siteAboutUs->setLanguage('fr');
        $siteAboutUs->setStatus($this->getReference('status-published'));
        $siteAboutUs->setDeleted(false);
        $siteAboutUs->setTemplateId('');
        $siteAboutUs->setTheme('themeAyman');
        $siteAboutUs->setInFooter(false);
        $siteAboutUs->setInMenu(false);
        $siteAboutUs->addArea($siteAboutUsArea0);
        $siteAboutUs->addArea($siteAboutUsArea4);
        $siteAboutUs->addArea($siteAboutUsArea7);
        $siteAboutUs->addBlock($siteAboutUsBlock1);
        $siteAboutUs->addBlock($siteAboutUsBlock2);
        $siteAboutUs->addBlock($siteAboutUsBlockMenu);
        $siteAboutUs->addBlock($siteAboutUsBlock4);
        $siteAboutUs->addBlock($siteAboutUsBlock5);
        $siteAboutUs->addBlock($siteAboutUsBlock6);
        $siteAboutUs->addBlock($siteAboutUsBlock7);

        return $siteAboutUs;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteOurTeam()
    {
        $siteOurTeamBlock1 = new Block();
        $siteOurTeamBlock1->setComponent('tiny_mce_wysiwyg');
        $siteOurTeamBlock1->setAttributes(array(
            "_htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themeAyman/img/logoOrchestra.png' /> </a>",
        ));

        $siteOurTeamBlock2 = new Block();
        $siteOurTeamBlock2->setComponent('tiny_mce_wysiwyg');
        $siteOurTeamBlock2->setAttributes(array(
            "_htmlContent" => "<ul id='mySubMenu'> <li><a href='/app_dev.php/node/fixture_page_about_us'> A PROPOS </a></li> <li><a href='/app_dev.php/node/fixture_page_our_team'> NOTRE EQUIPE </a></li><li><a href='/app_dev.php/node/fixture_page_news'> NOTRE ACTU </a></li><li><a href='/app_dev.php/node/fixture_page_join_us'>  NOUS REJOINDRE</a></li> <li><a href='/app_dev.php/node/fixture_page_networks'> NETWORKS </a></li> </ul>",
        ));

        $siteOurTeamBlockMenu = new Block();
        $siteOurTeamBlockMenu->setComponent('menu');
        $siteOurTeamBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));

        $siteOurTeamBlock4 = new Block();
        $siteOurTeamBlock4->setComponent('tiny_mce_wysiwyg');
        $siteOurTeamBlock4->setAttributes(array(
            "_htmlContent" => "<div class='content2'> <h1>Area1</h1></div>",
        ));

        $siteOurTeamBlock5 = new Block();
        $siteOurTeamBlock5->setComponent('tiny_mce_wysiwyg');
        $siteOurTeamBlock5->setAttributes(array(
            "_htmlContent" => "<div class='content3'>  <h3 class='blocTitle'><p class='titleModule'>Actu</p> </h3>   <div class='blockContent'> NEWS</div> </div>",
        ));

        $siteOurTeamBlock6 = new Block();
        $siteOurTeamBlock6->setComponent('contact');
        $siteOurTeamBlock6->setAttributes(array(
            "id" => "myFormContact",
            "class" => "myFormContact",
        ));

        $siteOurTeamBlock7 = new Block();
        $siteOurTeamBlock7->setComponent('tiny_mce_wysiwyg');
        $siteOurTeamBlock7->setAttributes(array(
            "_htmlContent" => "<div id='footerInfos'><h4>Infos</h4><ul><li> <a href=''>Qui sommes nous ?</a> </li><li> <a href=''>Contact</a> </li></ul></div> <div id='footerLegal'><h4>Légal</h4><ul><li> <a href=''>Mentions Légal</a> </li><li> <a href=''>Plan du site</a> </li></ul></div> <div id='footerNetworks'><h4>Networks</h4><ul><li> <a href='http://www.businessdecision.fr/'>http://www.businessdecision.fr/</a> </li><li> <a href='http://www.interakting.OurTeam/'>http://www.interakting.OurTeam/</a> </li></ul></div> <div id='footerContact'><h4>Contact</h4> <ul> <li>Interakting</li><li>153 Rue de Courcelles</li> <li>75017 Paris France</li> <li>01 56 21 21 21</li><li> <a href='#'>contact@interakting.OurTeam</a> </li></div>",
        ));

        $siteOurTeamArea1 = new Area();
        $siteOurTeamArea1->setAreaId('logo');
        $siteOurTeamArea1->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteOurTeamArea2 = new Area();
        $siteOurTeamArea2->setAreaId('sub_menu');
        $siteOurTeamArea2->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteOurTeamArea3 = new Area();
        $siteOurTeamArea3->setAreaId('main_menu');
        $siteOurTeamArea3->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteOurTeamArea0 = new Area();
        $siteOurTeamArea0->setAreaId('header');
        $siteOurTeamArea0->addArea($siteOurTeamArea1);
        $siteOurTeamArea0->addArea($siteOurTeamArea2);
        $siteOurTeamArea0->addArea($siteOurTeamArea3);

        $siteOurTeamArea5 = new Area();
        $siteOurTeamArea5->setAreaId('mainContentArea1');
        $siteOurTeamArea5->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteOurTeamArea6 = new Area();
        $siteOurTeamArea6->setAreaId('moduleArea');
        $siteOurTeamArea6->addBlock(array('nodeId' => 0, 'blockId' => 4));
        $siteOurTeamArea6->addBlock(array('nodeId' => 0, 'blockId' => 5));

        $siteOurTeamArea4 = new Area();
        $siteOurTeamArea4->setAreaId('myMain');
        $siteOurTeamArea4->addArea($siteOurTeamArea5);
        $siteOurTeamArea4->addArea($siteOurTeamArea6);

        $siteOurTeamArea8 = new Area();
        $siteOurTeamArea8->setAreaId('containeFooter');
        $siteOurTeamArea8->addBlock(array('nodeId' => 0, 'blockId' => 6));

        $siteOurTeamArea7 = new Area();
        $siteOurTeamArea7->setAreaId('footer');
        $siteOurTeamArea7->addArea($siteOurTeamArea8);

        $siteOurTeam = new Node();
        $siteOurTeam->setNodeId('fixture_page_our_team');
        $siteOurTeam->setNodeType('page');
        $siteOurTeam->setName('Fixture page our team');
        $siteOurTeam->setSiteId(2);
        $siteOurTeam->setParentId('fixture_page_home');
        $siteOurTeam->setPath('-');
        $siteOurTeam->setAlias('page-our-team');
        $siteOurTeam->setVersion(1);
        $siteOurTeam->setLanguage('fr');
        $siteOurTeam->setStatus($this->getReference('status-published'));
        $siteOurTeam->setDeleted(false);
        $siteOurTeam->setTemplateId('');
        $siteOurTeam->setTheme('themeAyman');
        $siteOurTeam->setInFooter(false);
        $siteOurTeam->setInMenu(false);
        $siteOurTeam->addArea($siteOurTeamArea0);
        $siteOurTeam->addArea($siteOurTeamArea4);
        $siteOurTeam->addArea($siteOurTeamArea7);
        $siteOurTeam->addBlock($siteOurTeamBlock1);
        $siteOurTeam->addBlock($siteOurTeamBlock2);
        $siteOurTeam->addBlock($siteOurTeamBlockMenu);
        $siteOurTeam->addBlock($siteOurTeamBlock4);
        $siteOurTeam->addBlock($siteOurTeamBlock5);
        $siteOurTeam->addBlock($siteOurTeamBlock6);
        $siteOurTeam->addBlock($siteOurTeamBlock7);

        return $siteOurTeam;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteNews()
    {
        $siteNewsBlock1 = new Block();
        $siteNewsBlock1->setComponent('tiny_mce_wysiwyg');
        $siteNewsBlock1->setAttributes(array(
            "_htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themeAyman/img/logoOrchestra.png' /> </a>",
        ));

        $siteNewsBlock2 = new Block();
        $siteNewsBlock2->setComponent('tiny_mce_wysiwyg');
        $siteNewsBlock2->setAttributes(array(
            "_htmlContent" => "<ul id='mySubMenu'> <li><a href='/app_dev.php/node/fixture_page_about_us'> A PROPOS </a></li> <li><a href='/app_dev.php/node/fixture_page_our_team'> NOTRE EQUIPE </a></li><li><a href='/app_dev.php/node/fixture_page_news'> NOTRE ACTU </a></li><li><a href='/app_dev.php/node/fixture_page_join_us'>  NOUS REJOINDRE</a></li> <li><a href='/app_dev.php/node/fixture_page_networks'> NETWORKS </a></li> </ul>",
        ));

        $siteNewsBlockMenu = new Block();
        $siteNewsBlockMenu->setComponent('menu');
        $siteNewsBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));

        $siteNewsBlock4 = new Block();
        $siteNewsBlock4->setComponent('tiny_mce_wysiwyg');
        $siteNewsBlock4->setAttributes(array(
            "_htmlContent" => "<div class='content2'> <h1>Area1</h1></div>",
        ));

        $siteNewsBlock5 = new Block();
        $siteNewsBlock5->setComponent('tiny_mce_wysiwyg');
        $siteNewsBlock5->setAttributes(array(
            "_htmlContent" => "<div class='content3'>  <h3 class='blocTitle'><p class='titleModule'>Actu</p> </h3>   <div class='blockContent'> NEWS</div> </div>",
        ));

        $siteNewsBlock6 = new Block();
        $siteNewsBlock6->setComponent('contact');
        $siteNewsBlock6->setAttributes(array(
            "id" => "myFormContact",
            "class" => "myFormContact",
        ));

        $siteNewsBlock7 = new Block();
        $siteNewsBlock7->setComponent('tiny_mce_wysiwyg');
        $siteNewsBlock7->setAttributes(array(
            "_htmlContent" => "<div id='footerInfos'><h4>Infos</h4><ul><li> <a href=''>Qui sommes nous ?</a> </li><li> <a href=''>Contact</a> </li></ul></div> <div id='footerLegal'><h4>Légal</h4><ul><li> <a href=''>Mentions Légal</a> </li><li> <a href=''>Plan du site</a> </li></ul></div> <div id='footerNetworks'><h4>Networks</h4><ul><li> <a href='http://www.businessdecision.fr/'>http://www.businessdecision.fr/</a> </li><li> <a href='http://www.interakting.News/'>http://www.interakting.News/</a> </li></ul></div> <div id='footerContact'><h4>Contact</h4> <ul> <li>Interakting</li><li>153 Rue de Courcelles</li> <li>75017 Paris France</li> <li>01 56 21 21 21</li><li> <a href='#'>contact@interakting.News</a> </li></div>",
        ));

        $siteNewsArea1 = new Area();
        $siteNewsArea1->setAreaId('logo');
        $siteNewsArea1->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteNewsArea2 = new Area();
        $siteNewsArea2->setAreaId('sub_menu');
        $siteNewsArea2->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteNewsArea3 = new Area();
        $siteNewsArea3->setAreaId('main_menu');
        $siteNewsArea3->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteNewsArea0 = new Area();
        $siteNewsArea0->setAreaId('header');
        $siteNewsArea0->addArea($siteNewsArea1);
        $siteNewsArea0->addArea($siteNewsArea2);
        $siteNewsArea0->addArea($siteNewsArea3);

        $siteNewsArea5 = new Area();
        $siteNewsArea5->setAreaId('mainContentArea1');
        $siteNewsArea5->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteNewsArea6 = new Area();
        $siteNewsArea6->setAreaId('moduleArea');
        $siteNewsArea6->addBlock(array('nodeId' => 0, 'blockId' => 4));
        $siteNewsArea6->addBlock(array('nodeId' => 0, 'blockId' => 5));

        $siteNewsArea4 = new Area();
        $siteNewsArea4->setAreaId('myMain');
        $siteNewsArea4->addArea($siteNewsArea5);
        $siteNewsArea4->addArea($siteNewsArea6);

        $siteNewsArea8 = new Area();
        $siteNewsArea8->setAreaId('containeFooter');
        $siteNewsArea8->addBlock(array('nodeId' => 0, 'blockId' => 6));

        $siteNewsArea7 = new Area();
        $siteNewsArea7->setAreaId('footer');
        $siteNewsArea7->addArea($siteNewsArea8);

        $siteNews = new Node();
        $siteNews->setNodeId('fixture_page_news');
        $siteNews->setNodeType('page');
        $siteNews->setName('Fixture page news');
        $siteNews->setSiteId(2);
        $siteNews->setParentId('fixture_page_home');
        $siteNews->setPath('-');
        $siteNews->setAlias('page our news');
        $siteNews->setVersion(1);
        $siteNews->setLanguage('fr');
        $siteNews->setStatus($this->getReference('status-published'));
        $siteNews->setDeleted(false);
        $siteNews->setTemplateId('');
        $siteNews->setTheme('themeAyman');
        $siteNews->setInFooter(false);
        $siteNews->setInMenu(false);
        $siteNews->addArea($siteNewsArea0);
        $siteNews->addArea($siteNewsArea4);
        $siteNews->addArea($siteNewsArea7);
        $siteNews->addBlock($siteNewsBlock1);
        $siteNews->addBlock($siteNewsBlock2);
        $siteNews->addBlock($siteNewsBlockMenu);
        $siteNews->addBlock($siteNewsBlock4);
        $siteNews->addBlock($siteNewsBlock5);
        $siteNews->addBlock($siteNewsBlock6);
        $siteNews->addBlock($siteNewsBlock7);

        return $siteNews;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteJoinUs()
    {
        $siteJoinUsBlock1 = new Block();
        $siteJoinUsBlock1->setComponent('tiny_mce_wysiwyg');
        $siteJoinUsBlock1->setAttributes(array(
            "_htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themeAyman/img/logoOrchestra.png' /> </a>",
        ));

        $siteJoinUsBlock2 = new Block();
        $siteJoinUsBlock2->setComponent('tiny_mce_wysiwyg');
        $siteJoinUsBlock2->setAttributes(array(
            "_htmlContent" => "<ul id='mySubMenu'> <li><a href='/app_dev.php/node/fixture_page_about_us'> A PROPOS </a></li> <li><a href='/app_dev.php/node/fixture_page_our_team'> NOTRE EQUIPE </a></li><li><a href='/app_dev.php/node/fixture_page_news'> NOTRE ACTU </a></li><li><a href='/app_dev.php/node/fixture_page_join_us'>  NOUS REJOINDRE</a></li> <li><a href='/app_dev.php/node/fixture_page_networks'> NETWORKS </a></li> </ul>",
        ));

        $siteJoinUsBlockMenu = new Block();
        $siteJoinUsBlockMenu->setComponent('menu');
        $siteJoinUsBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));

        $siteJoinUsBlock4 = new Block();
        $siteJoinUsBlock4->setComponent('tiny_mce_wysiwyg');
        $siteJoinUsBlock4->setAttributes(array(
            "_htmlContent" => "<div class='content2'><div id='annonce'><h1>Nous rejoindre</h1> <p>Vous êtes un passionné d’Internet en général et du Web en particulier?</p> <p>Vous avez une expérience significative dans les domaines suivants: Développement web le framwork Symfony 2 Votre profil est susceptible de nous intéresser </div> <div id='form'><table border='0'><tbody><tr><td valign='top'> Nom   </td><td> <input type='text' placeholder='Votre nom' required/> </td></tr><tr> <td valign='top'> Société   </td><td> <input type='text' placeholder='Votre société'/> </td></tr><tr> <td valign='top'> Email   </td><td> <input type='email' placeholder='Votre e-mail' required/> </td></tr><tr> <td valign='top'> Téléphone </td><td> <input type='tel' placeholder='Votre téléphone' required/> </td></tr><tr> <td valign='top'> Message   </td><td> <textarea  rows='10' cols='25' placeholder='Votre message' required> </textarea> </td></tr><tr> <td valign='top'> CV   </td><td><input type='file' /> </td></tr> <tr> <td> <input type='submit' value='OK'/></td>  </tr> </tbody></table></div> </div>",
        ));

        $siteJoinUsBlock5 = new Block();
        $siteJoinUsBlock5->setComponent('tiny_mce_wysiwyg');
        $siteJoinUsBlock5->setAttributes(array(
            "_htmlContent" => "<div class='content3'>  <h3 class='blocTitle'><p class='titleModule'>Actu</p> </h3>   <div class='blockContent'> NEWS</div> </div>",
        ));

        $siteJoinUsBlock6 = new Block();
        $siteJoinUsBlock6->setComponent('tiny_mce_wysiwyg');
        $siteJoinUsBlock6->setAttributes(array(
            "_htmlContent" => "<div class='content3'><h3 class='blocTitle'><p class='titleModule'> Nous rejoindre </p> </h3><div class='blockContent'>Nos annonces </div> </div> ",
        ));

        $siteJoinUsBlock8 = new Block();
        $siteJoinUsBlock8->setComponent('tiny_mce_wysiwyg');
        $siteJoinUsBlock8->setAttributes(array(
            "_htmlContent" => "<div id='footerInfos'><h4>Infos</h4><ul><li> <a href=''>Qui sommes nous ?</a> </li><li> <a href=''>Contact</a> </li></ul></div> <div id='footerLegal'><h4>Légal</h4><ul><li> <a href=''>Mentions Légal</a> </li><li> <a href=''>Plan du site</a> </li></ul></div> <div id='footerNetworks'><h4>Networks</h4><ul><li> <a href='http://www.businessdecision.fr/'>http://www.businessdecision.fr/</a> </li><li> <a href='http://www.interakting.JoinUs/'>http://www.interakting.JoinUs/</a> </li></ul></div> <div id='footerContact'><h4>Contact</h4> <ul> <li>Interakting</li><li>153 Rue de Courcelles</li> <li>75017 Paris France</li> <li>01 56 21 21 21</li><li> <a href='#'>contact@interakting.JoinUs</a> </li></div>",
        ));

        $siteJoinUsArea1 = new Area();
        $siteJoinUsArea1->setAreaId('logo');
        $siteJoinUsArea1->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteJoinUsArea2 = new Area();
        $siteJoinUsArea2->setAreaId('sub_menu');
        $siteJoinUsArea2->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteJoinUsArea3 = new Area();
        $siteJoinUsArea3->setAreaId('main_menu');
        $siteJoinUsArea3->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteJoinUsArea0 = new Area();
        $siteJoinUsArea0->setAreaId('header');
        $siteJoinUsArea0->addArea($siteJoinUsArea1);
        $siteJoinUsArea0->addArea($siteJoinUsArea2);
        $siteJoinUsArea0->addArea($siteJoinUsArea3);

        $siteJoinUsArea5 = new Area();
        $siteJoinUsArea5->setAreaId('mainContentArea1');
        $siteJoinUsArea5->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteJoinUsArea6 = new Area();
        $siteJoinUsArea6->setAreaId('moduleArea');
        $siteJoinUsArea6->addBlock(array('nodeId' => 0, 'blockId' => 4));
        $siteJoinUsArea6->addBlock(array('nodeId' => 0, 'blockId' => 5));

        $siteJoinUsArea4 = new Area();
        $siteJoinUsArea4->setAreaId('myMain');
        $siteJoinUsArea4->addArea($siteJoinUsArea5);
        $siteJoinUsArea4->addArea($siteJoinUsArea6);

        $siteJoinUsArea8 = new Area();
        $siteJoinUsArea8->setAreaId('containeFooter');
        $siteJoinUsArea8->addBlock(array('nodeId' => 0, 'blockId' => 6));

        $siteJoinUsArea7 = new Area();
        $siteJoinUsArea7->setAreaId('footer');
        $siteJoinUsArea7->addArea($siteJoinUsArea8);

        $siteJoinUs = new Node();
        $siteJoinUs->setNodeId('fixture_page_join_us');
        $siteJoinUs->setNodeType('page');
        $siteJoinUs->setName('Fixture page join us');
        $siteJoinUs->setSiteId(2);
        $siteJoinUs->setParentId('fixture_page_home');
        $siteJoinUs->setPath('-');
        $siteJoinUs->setAlias('page-nous-rejoindre');
        $siteJoinUs->setVersion(1);
        $siteJoinUs->setLanguage('fr');
        $siteJoinUs->setStatus($this->getReference('status-published'));
        $siteJoinUs->setDeleted(false);
        $siteJoinUs->setTemplateId('');
        $siteJoinUs->setTheme('themeAyman');
        $siteJoinUs->setInFooter(false);
        $siteJoinUs->setInMenu(false);
        $siteJoinUs->addArea($siteJoinUsArea0);
        $siteJoinUs->addArea($siteJoinUsArea4);
        $siteJoinUs->addArea($siteJoinUsArea7);
        $siteJoinUs->addBlock($siteJoinUsBlock1);
        $siteJoinUs->addBlock($siteJoinUsBlock2);
        $siteJoinUs->addBlock($siteJoinUsBlockMenu);
        $siteJoinUs->addBlock($siteJoinUsBlock4);
        $siteJoinUs->addBlock($siteJoinUsBlock5);
        $siteJoinUs->addBlock($siteJoinUsBlock6);
        $siteJoinUs->addBlock($siteJoinUsBlock8);

        return $siteJoinUs;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteNetwork()
    {
        $siteNetworkBlock1 = new Block();
        $siteNetworkBlock1->setComponent('tiny_mce_wysiwyg');
        $siteNetworkBlock1->setAttributes(array(
            "_htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themeAyman/img/logoOrchestra.png' /> </a>",
        ));

        $siteNetworkBlock2 = new Block();
        $siteNetworkBlock2->setComponent('tiny_mce_wysiwyg');
        $siteNetworkBlock2->setAttributes(array(
            "_htmlContent" => "<ul id='mySubMenu'> <li><a href='/app_dev.php/node/fixture_page_about_us'> A PROPOS </a></li> <li><a href='/app_dev.php/node/fixture_page_our_team'> NOTRE EQUIPE </a></li><li><a href='/app_dev.php/node/fixture_page_news'> NOTRE ACTU </a></li><li><a href='/app_dev.php/node/fixture_page_join_us'>  NOUS REJOINDRE</a></li> <li><a href='/app_dev.php/node/fixture_page_networks'> NETWORKS </a></li> </ul>",
        ));

        $siteNetworkBlockMenu = new Block();
        $siteNetworkBlockMenu->setComponent('menu');
        $siteNetworkBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));

        $siteNetworkBlock4 = new Block();
        $siteNetworkBlock4->setComponent('tiny_mce_wysiwyg');
        $siteNetworkBlock4->setAttributes(array(
            "_htmlContent" => "<div class='content2'> <h1><p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia neque sed consequat dapibus. Nulla hendrerit mollis nisi vitae vehicula. Maecenas viverra lacus neque, quis viverra ligula dignissim vel. Nulla interdum pulvinar vulputate. Cras at urna sem. Nullam sed risus porta, placerat metus bibendum, commodo metus. Donec blandit leo eros, sed convallis odio sollicitudin at.Morbi ut pulvinar lorem. Duis venenatis interdum hendrerit. Curabitur sit amet eleifend sapien. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse volutpat nulla sed eleifend malesuada. Suspendisse fringilla, est et dapibus molestie, orci leo pretium nulla, vitae consectetur ipsum enim ut magna. Duis sagittis auctor sollicitudin. Nunc interdum, quam id varius interdum, nulla felis blandit sapien, ac egestas lectus turpis in urna. Sed id ullamcorper nulla, quis tempor libero. Donec aliquet neque vitae rhoncus vestibulum. Aliquam id nunc ut justo sagittis bibendum sit amet non metus.Mauris aliquam mattis sem, in tempus eros feugiat non. Aenean vitae odio sapien. Curabitur ut luctus purus, nec vehicula nunc. Sed massa odio, sagittis a odio eget, posuere imperdiet eros. Sed sit amet neque tempus urna rutrum egestas. Maecenas dignissim justo orci, vitae aliquet mi gravida feugiat. Quisque ullamcorper non dui eget fringilla. convallis condimentum placerat. Mauris bibendum libero ac neque tempus, et pharetra enim cursus. In nec porta mi. Duis feugiat, enim nec ornare malesuada, ligula metus iaculis quam, dapibus fermentum lacus lorem ut diam. Pellentesque condimentum ante sed augue pretium placerat. Ut venenatis, lacus vel imperdiet aliquam, enim risus rhoncus mi, eget consequat tellus ante nec felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur in erat eget leo tincidunt euismod. Sed hendrerit malesuada magna commodo porta. Suspendisse diam urna, pretium ut mi vel, vulputate ultricies dolor. Nam eleifend accumsan nibh. Duis hendrerit ornare urna, sit amet commodo eros imperdiet nec.Donec tristique est sit amet justo fringilla, a hendrerit ligula ultricies. Phasellus dignissim mi sit amet nibh gravida, vitae lobortis lorem imperdiet. Praesent dolor quam, luctus sed dui eu, eleifend mattis tortor. Curabitur varius lacus at sapien eleifend, vitae feugiat lectus mattis. In malesuada molestie turpis, et mattis ante euismod sed. Integer interdum adipiscing purus vitae vestibulum. Proin aliquam egestas nunc, ut dictum justo lacinia quis. Phasellus tincidunt mauris fringilla mauris hendrerit euismod.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia neque sed consequat dapibus. Nulla hendrerit mollis nisi vitae vehicula. Maecenas viverra lacus neque, quis viverra ligula dignissim vel. Nulla interdum pulvinar vulputate.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia neque sed consequat dapibus. Nulla hendrerit mollis nisi vitae vehicula. Maecenas viverra lacus neque, quis viverra ligula dignissim vel. Nulla interdum pulvinar vulputate.</p></h1></div>",
        ));

        $siteNetworkBlock5 = new Block();
        $siteNetworkBlock5->setComponent('tiny_mce_wysiwyg');
        $siteNetworkBlock5->setAttributes(array(
            "_htmlContent" => "<div class='content3'>  <h3 class='blocTitle'><p class='titleModule'>Actu</p> </h3>   <div class='blockContent'> NEWS</div> </div>",

        ));

        $siteNetworkBlock6 = new Block();
        $siteNetworkBlock6->setComponent('contact');
        $siteNetworkBlock6->setAttributes(array(
            "id" => "myFormContact",
            "class" => "myFormContact",
        ));

        $siteNetworkBlock7 = new Block();
        $siteNetworkBlock7->setComponent('tiny_mce_wysiwyg');
        $siteNetworkBlock7->setAttributes(array(
            "_htmlContent" => "<div id='footerInfos'><h4>Infos</h4><ul><li> <a href=''>Qui sommes nous ?</a> </li><li> <a href=''>Contact</a> </li></ul></div> <div id='footerLegal'><h4>Légal</h4><ul><li> <a href=''>Mentions Légal</a> </li><li> <a href=''>Plan du site</a> </li></ul></div> <div id='footerNetworks'><h4>Networks</h4><ul><li> <a href='http://www.businessdecision.fr/'>http://www.businessdecision.fr/</a> </li><li> <a href='http://www.interakting.Network/'>http://www.interakting.Network/</a> </li></ul></div> <div id='footerContact'><h4>Contact</h4> <ul> <li>Interakting</li><li>153 Rue de Courcelles</li> <li>75017 Paris France</li> <li>01 56 21 21 21</li><li> <a href='#'>contact@interakting.Network</a> </li></div>",
        ));

        $siteNetworkArea1 = new Area();
        $siteNetworkArea1->setAreaId('logo');
        $siteNetworkArea1->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteNetworkArea2 = new Area();
        $siteNetworkArea2->setAreaId('sub_menu');
        $siteNetworkArea2->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteNetworkArea3 = new Area();
        $siteNetworkArea3->setAreaId('main_menu');
        $siteNetworkArea3->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteNetworkArea0 = new Area();
        $siteNetworkArea0->setAreaId('header');
        $siteNetworkArea0->addArea($siteNetworkArea1);
        $siteNetworkArea0->addArea($siteNetworkArea2);
        $siteNetworkArea0->addArea($siteNetworkArea3);

        $siteNetworkArea5 = new Area();
        $siteNetworkArea5->setAreaId('mainContentArea1');
        $siteNetworkArea5->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteNetworkArea6 = new Area();
        $siteNetworkArea6->setAreaId('moduleArea');
        $siteNetworkArea6->addBlock(array('nodeId' => 0, 'blockId' => 4), array('nodeId' => 0, 'blockId' => 5));
        $siteNetworkArea6->addBlock(array('nodeId' => 0, 'blockId' => 5));

        $siteNetworkArea4 = new Area();
        $siteNetworkArea4->setAreaId('myMain');
        $siteNetworkArea4->addArea($siteNetworkArea5);
        $siteNetworkArea4->addArea($siteNetworkArea6);

        $siteNetworkArea8 = new Area();
        $siteNetworkArea8->setAreaId('containeFooter');
        $siteNetworkArea8->addBlock(array('nodeId' => 0, 'blockId' => 6));

        $siteNetworkArea7 = new Area();
        $siteNetworkArea7->setAreaId('footer');
        $siteNetworkArea7->addArea($siteNetworkArea8);

        $siteNetwork = new Node();
        $siteNetwork->setNodeId('fixture_page_networks');
        $siteNetwork->setNodeType('page');
        $siteNetwork->setName('Fixture page networks');
        $siteNetwork->setSiteId(2);
        $siteNetwork->setParentId('fixture_page_home');
        $siteNetwork->setPath('-');
        $siteNetwork->setAlias('page-networks');
        $siteNetwork->setVersion(1);
        $siteNetwork->setLanguage('fr');
        $siteNetwork->setStatus($this->getReference('status-published'));
        $siteNetwork->setDeleted(false);
        $siteNetwork->setTemplateId('');
        $siteNetwork->setTheme('themeAyman');
        $siteNetwork->setInFooter(false);
        $siteNetwork->setInMenu(false);
        $siteNetwork->addArea($siteNetworkArea0);
        $siteNetwork->addArea($siteNetworkArea4);
        $siteNetwork->addArea($siteNetworkArea7);
        $siteNetwork->addBlock($siteNetworkBlock1);
        $siteNetwork->addBlock($siteNetworkBlock2);
        $siteNetwork->addBlock($siteNetworkBlockMenu);
        $siteNetwork->addBlock($siteNetworkBlock4);
        $siteNetwork->addBlock($siteNetworkBlock5);
        $siteNetwork->addBlock($siteNetworkBlock6);
        $siteNetwork->addBlock($siteNetworkBlock7);

        return $siteNetwork;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteContact()
    {
        $siteContactBlock1 = new Block();
        $siteContactBlock1->setComponent('tiny_mce_wysiwyg');
        $siteContactBlock1->setAttributes(array(
            "_htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themeAyman/img/logoOrchestra.png' /> </a>",
        ));

        $siteContactBlock2 = new Block();
        $siteContactBlock2->setComponent('tiny_mce_wysiwyg');
        $siteContactBlock2->setAttributes(array(
            "_htmlContent" => "<ul id='mySubMenu'> <li><a href='/app_dev.php/node/fixture_page_about_us'> A PROPOS </a></li> <li><a href='/app_dev.php/node/fixture_page_our_team'> NOTRE EQUIPE </a></li><li><a href='/app_dev.php/node/fixture_page_news'> NOTRE ACTU </a></li><li><a href='/app_dev.php/node/fixture_page_join_us'>  NOUS REJOINDRE</a></li> <li><a href='/app_dev.php/node/fixture_page_networks'> NETWORKS </a></li> </ul>",
        ));

        $siteContactBlockMenu = new Block();
        $siteContactBlockMenu->setComponent('menu');
        $siteContactBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));

        $siteContactBlock4 = new Block();
        $siteContactBlock4->setComponent('tiny_mce_wysiwyg');
        $siteContactBlock4->setAttributes(array(
            "_htmlContent" => "<div class='content2' id='contactArea' ><div id='contactInformation'><h3>Contactez-nous</h3><img src='/bundles/phporchestrasite/images/logoOrchestra.png' /><div id='infoInterakting'><p><b>Interakting</b> <br>Groupe Business & Decision<br>153 Rue de Courcelles<br>75017 PARIS FRANCE<br><span class='fontOrange'>Tél:</span> +33 1 56 21 21 21<br> <span class='fontOrange'>Fax:</span> +33 1 56 21 21 22</p></div><div id='accessInterakting'><h3>Accès:</h3> <p><span class='fontOrange'>Metro ligne 3</span> arrêt Pereire<br><span class='fontOrange'>RER ligne C</span> arrêt Pereire-Levallois</p> </div><div id='googleMapsInterakting'><iframe width='425' height='350' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://maps.google.fr/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=153+Rue+de+Courcelles+75817+Paris&amp;aq=&amp;sll=48.834414,2.499298&amp;sspn=0.523838,0.909805&amp;ie=UTF8&amp;hq=&amp;hnear=153+Rue+de+Courcelles,+75817+Paris&amp;ll=48.883747,2.298345&amp;spn=0.004088,0.007108&amp;t=m&amp;z=14&amp;output=embed'></iframe><br /><small><a href='https://maps.google.fr/maps?f=q&amp;source=embed&amp;hl=fr&amp;geocode=&amp;q=153+Rue+de+Courcelles+75817+Paris&amp;aq=&amp;sll=48.834414,2.499298&amp;sspn=0.523838,0.909805&amp;ie=UTF8&amp;hq=&amp;hnear=153+Rue+de+Courcelles,+75817+Paris&amp;ll=48.883747,2.298345&amp;spn=0.004088,0.007108&amp;t=m&amp;z=14' style='color:#0000FF;text-align:left'>Agrandir le plan</a></small></div></div><div id='contactForm'><h3>Une Demande ?<table border='0'><tbody><tr><td valign='top'> Nom </td><td> <input type='text' placeholder='Votre nom' required/> </td></tr><tr> <td valign='top'> Société </td><td> <input type='text' placeholder='Votre société'/> </td></tr><tr><td valign='top'> Email  </td><td> <input type='email' placeholder='Votre e-mail' required/> </td></tr><tr> <td valign='top'> Téléphone </td><td> <input type='tel' placeholder='Votre téléphone' required/></tr><tr><td valign='top'> Sujet   </td><td> <input type='text' placeholder='Votre sujet' required/> </td></tr><tr> <td valign='top'> Type de demande   </td><td> <select><option> Orchestra </option><option> Presse </option><option> Information </option><option> Emploi </option></select></td></tr><tr><td valign='top'> Message </td><td> <textarea  rows='10' cols='25' placeholder='Votre message' required> </textarea> </td></tr> <tr> <td> <input type='submit' value='OK' /></td> </tr> </tbody></table></div></div>",
        ));

        $siteContactBlock5 = new Block();
        $siteContactBlock5->setComponent('tiny_mce_wysiwyg');
        $siteContactBlock5->setAttributes(array(
            "_htmlContent" => "<div id='footerInfos'><h4>Infos</h4><ul><li> <a href=''>Qui sommes nous ?</a> </li><li> <a href=''>Contact</a> </li></ul></div> <div id='footerLegal'><h4>Légal</h4><ul><li> <a href=''>Mentions Légal</a> </li><li> <a href=''>Plan du site</a> </li></ul></div> <div id='footerNetworks'><h4>Networks</h4><ul><li> <a href='http://www.businessdecision.fr/'>http://www.businessdecision.fr/</a> </li><li> <a href='http://www.interakting.com/'>http://www.interakting.com/</a> </li></ul></div> <div id='footerContact'><h4>Contact</h4> <ul> <li>Interakting</li><li>153 Rue de Courcelles</li> <li>75017 Paris France</li> <li>01 56 21 21 21</li><li> <a href='#'>contact@interakting.com </a> </li></div>",
        ));

        $siteContactArea1 = new Area();
        $siteContactArea1->setAreaId('logo');
        $siteContactArea1->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteContactArea2 = new Area();
        $siteContactArea2->setAreaId('sub_menu');
        $siteContactArea2->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteContactArea3 = new Area();
        $siteContactArea3->setAreaId('main_menu');
        $siteContactArea3->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteContactArea0 = new Area();
        $siteContactArea0->setAreaId('header');
        $siteContactArea0->addArea($siteContactArea1);
        $siteContactArea0->addArea($siteContactArea2);
        $siteContactArea0->addArea($siteContactArea3);

        $siteContactArea5 = new Area();
        $siteContactArea5->setAreaId('mainContentArea1');
        $siteContactArea5->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteContactArea4 = new Area();
        $siteContactArea4->setAreaId('myMain');
        $siteContactArea4->addArea($siteContactArea5);

        $siteContactArea8 = new Area();
        $siteContactArea8->setAreaId('containeFooter');
        $siteContactArea8->addBlock(array('nodeId' => 0, 'blockId' => 4));

        $siteContactArea7 = new Area();
        $siteContactArea7->setAreaId('footer');
        $siteContactArea7->addArea($siteContactArea8);

        $siteContact = new Node();
        $siteContact->setNodeId('fixture_page_contact');
        $siteContact->setNodeType('page');
        $siteContact->setName('Contact');
        $siteContact->setSiteId(2);
        $siteContact->setParentId('fixture_page_home');
        $siteContact->setPath('-');
        $siteContact->setAlias('page-contact');
        $siteContact->setVersion(1);
        $siteContact->setLanguage('fr');
        $siteContact->setStatus($this->getReference('status-published'));
        $siteContact->setDeleted(false);
        $siteContact->setTemplateId('');
        $siteContact->setTheme('themeAyman');
        $siteContact->setInFooter(false);
        $siteContact->setInMenu(true);
        $siteContact->addArea($siteContactArea0);
        $siteContact->addArea($siteContactArea4);
        $siteContact->addArea($siteContactArea7);
        $siteContact->addBlock($siteContactBlock1);
        $siteContact->addBlock($siteContactBlock2);
        $siteContact->addBlock($siteContactBlockMenu);
        $siteContact->addBlock($siteContactBlock4);
        $siteContact->addBlock($siteContactBlock5);

        return $siteContact;
    }

    /**
     * @return Node
     */
    public function generateNodeSiteLegalMentions()
    {
        $siteLegalBlock1 = new Block();
        $siteLegalBlock1->setComponent('tiny_mce_wysiwyg');
        $siteLegalBlock1->setAttributes(array(
            "_htmlContent" => "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/themeAyman/img/logoOrchestra.png' /> </a>",
        ));

        $siteLegalBlock2 = new Block();
        $siteLegalBlock2->setComponent('tiny_mce_wysiwyg');
        $siteLegalBlock2->setAttributes(array(
            "_htmlContent" => "<ul id='mySubMenu'> <li><a href='/app_dev.php/node/fixture_page_about_us'> A PROPOS </a></li> <li><a href='/app_dev.php/node/fixture_page_our_team'> NOTRE EQUIPE </a></li><li><a href='/app_dev.php/node/fixture_page_news'> NOTRE ACTU </a></li><li><a href='/app_dev.php/node/fixture_page_join_us'>  NOUS REJOINDRE</a></li> <li><a href='/app_dev.php/node/fixture_page_networks'> NETWORKS </a></li> </ul>",
        ));

        $siteLegalBlockMenu = new Block();
        $siteLegalBlockMenu->setComponent('menu');
        $siteLegalBlockMenu->setAttributes(array(
            'class' => array(
                'div' => 'divclass',
                'ul' => 'ulclass',
                'link' => 'linkclass'
            ),
            'id' => 'myMainMenu',
        ));

        $siteLegalBlock4 = new Block();
        $siteLegalBlock4->setComponent('tiny_mce_wysiwyg');
        $siteLegalBlock4->setAttributes(array(
            "_htmlContent" => "<div class='content2'> <h1><p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia neque sed consequat dapibus. Nulla hendrerit mollis nisi vitae vehicula. Maecenas viverra lacus neque, quis viverra ligula dignissim vel. Nulla interdum pulvinar vulputate. Cras at urna sem. Nullam sed risus porta, placerat metus bibendum, commodo metus. Donec blandit leo eros, sed convallis odio sollicitudin at.Morbi ut pulvinar lorem. Duis venenatis interdum hendrerit. Curabitur sit amet eleifend sapien. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse volutpat nulla sed eleifend malesuada. Suspendisse fringilla, est et dapibus molestie, orci leo pretium nulla, vitae consectetur ipsum enim ut magna. Duis sagittis auctor sollicitudin. Nunc interdum, quam id varius interdum, nulla felis blandit sapien, ac egestas lectus turpis in urna. Sed id ullamcorper nulla, quis tempor libero. Donec aliquet neque vitae rhoncus vestibulum. Aliquam id nunc ut justo sagittis bibendum sit amet non metus.Mauris aliquam mattis sem, in tempus eros feugiat non. Aenean vitae odio sapien. Curabitur ut luctus purus, nec vehicula nunc. Sed massa odio, sagittis a odio eget, posuere imperdiet eros. Sed sit amet neque tempus urna rutrum egestas. Maecenas dignissim justo orci, vitae aliquet mi gravida feugiat. Quisque ullamcorper non dui eget fringilla. convallis condimentum placerat. Mauris bibendum libero ac neque tempus, et pharetra enim cursus. In nec porta mi. Duis feugiat, enim nec ornare malesuada, ligula metus iaculis quam, dapibus fermentum lacus lorem ut diam. Pellentesque condimentum ante sed augue pretium placerat. Ut venenatis, lacus vel imperdiet aliquam, enim risus rhoncus mi, eget consequat tellus ante nec felis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur in erat eget leo tincidunt euismod. Sed hendrerit malesuada magna commodo porta. Suspendisse diam urna, pretium ut mi vel, vulputate ultricies dolor. Nam eleifend accumsan nibh. Duis hendrerit ornare urna, sit amet commodo eros imperdiet nec.Donec tristique est sit amet justo fringilla, a hendrerit ligula ultricies. Phasellus dignissim mi sit amet nibh gravida, vitae lobortis lorem imperdiet. Praesent dolor quam, luctus sed dui eu, eleifend mattis tortor. Curabitur varius lacus at sapien eleifend, vitae feugiat lectus mattis. In malesuada molestie turpis, et mattis ante euismod sed. Integer interdum adipiscing purus vitae vestibulum. Proin aliquam egestas nunc, ut dictum justo lacinia quis. Phasellus tincidunt mauris fringilla mauris hendrerit euismod.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia neque sed consequat dapibus. Nulla hendrerit mollis nisi vitae vehicula. Maecenas viverra lacus neque, quis viverra ligula dignissim vel. Nulla interdum pulvinar vulputate.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi lacinia neque sed consequat dapibus. Nulla hendrerit mollis nisi vitae vehicula. Maecenas viverra lacus neque, quis viverra ligula dignissim vel. Nulla interdum pulvinar vulputate.</p></h1></div>",
        ));

        $siteLegalBlock5 = new Block();
        $siteLegalBlock5->setComponent('tiny_mce_wysiwyg');
        $siteLegalBlock5->setAttributes(array(
            "_htmlContent" => "<div class='content3'>  <h3 class='blocTitle'><p class='titleModule'>Actu</p> </h3>   <div class='blockContent'> NEWS</div> </div>",
        ));

        $siteLegalArea1 = new Area();
        $siteLegalArea1->setAreaId('logo');
        $siteLegalArea1->addBlock(array('nodeId' => 0, 'blockId' => 0));

        $siteLegalArea2 = new Area();
        $siteLegalArea2->setAreaId('sub_menu');
        $siteLegalArea2->addBlock(array('nodeId' => 0, 'blockId' => 1));

        $siteLegalArea3 = new Area();
        $siteLegalArea3->setAreaId('main_menu');
        $siteLegalArea3->addBlock(array('nodeId' => 0, 'blockId' => 2));

        $siteLegalArea0 = new Area();
        $siteLegalArea0->setAreaId('header');
        $siteLegalArea0->addArea($siteLegalArea1);
        $siteLegalArea0->addArea($siteLegalArea2);
        $siteLegalArea0->addArea($siteLegalArea3);

        $siteLegalArea5 = new Area();
        $siteLegalArea5->setAreaId('mainContentArea1');
        $siteLegalArea5->addBlock(array('nodeId' => 0, 'blockId' => 3));

        $siteLegalArea6 = new Area();
        $siteLegalArea6->setAreaId('moduleArea');
        $siteLegalArea6->addBlock(array('nodeId' => 0, 'blockId' => 4), array('nodeId' => 0, 'blockId' => 5));

        $siteLegalArea4 = new Area();
        $siteLegalArea4->setAreaId('myMain');
        $siteLegalArea4->addArea($siteLegalArea5);
        $siteLegalArea4->addArea($siteLegalArea6);

        $siteLegal = new Node();
        $siteLegal->setNodeId('fixture_page_legal_mentions');
        $siteLegal->setNodeType('page');
        $siteLegal->setName('Fixture page legal mentions');
        $siteLegal->setSiteId(2);
        $siteLegal->setParentId('fixture_page_home');
        $siteLegal->setPath('-');
        $siteLegal->setAlias('page legal mentions');
        $siteLegal->setVersion(1);
        $siteLegal->setLanguage('fr');
        $siteLegal->setStatus($this->getReference('status-published'));
        $siteLegal->setDeleted(false);
        $siteLegal->setTemplateId('');
        $siteLegal->setTheme('themeAyman');
        $siteLegal->setInFooter(false);
        $siteLegal->setInMenu(false);
        $siteLegal->addArea($siteLegalArea0);
        $siteLegal->addArea($siteLegalArea4);
        $siteLegal->addBlock($siteLegalBlock1);
        $siteLegal->addBlock($siteLegalBlock2);
        $siteLegal->addBlock($siteLegalBlockMenu);
        $siteLegal->addBlock($siteLegalBlock4);
        $siteLegal->addBlock($siteLegalBlock5);

        return $siteLegal;
    }
}
