<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Area;
use PHPOrchestra\ModelBundle\Document\Block;
use PHPOrchestra\ModelBundle\Document\Node;
use PHPOrchestra\ModelBundle\Model\NodeInterface;

/**
 * Class LoadNodeEchonextData
 */
class LoadNodeEchonextData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $manager->persist($this->generateNodeTransverse('fr'));
        $manager->persist($this->generateNodeHome('fr'));
        $manager->persist($this->generateEspaceBDDF('fr'));
        $manager->persist($this->generateEspaceCardif('fr'));
        $manager->persist($this->generateEspaceArval('fr'));
        $manager->persist($this->generateEspaceXXX('fr'));
        $manager->persist($this->generateCardifBienvenu('fr'));
        $manager->persist($this->generateCardifActualite('fr'));
        $manager->persist($this->generateCardifMissions('fr'));
        $manager->persist($this->generateCardifRemun('fr'));
        $manager->persist($this->generateNodeNews('fr'));

        $manager->persist($this->generateNodeTransverse('en'));
        $manager->persist($this->generateNodeHome('en'));
        $manager->persist($this->generateEspaceBDDF('en'));
        $manager->persist($this->generateEspaceCardif('en'));
        $manager->persist($this->generateEspaceArval('en'));
        $manager->persist($this->generateEspaceXXX('en'));
        $manager->persist($this->generateCardifBienvenu('en'));
        $manager->persist($this->generateCardifActualite('en'));
        $manager->persist($this->generateCardifMissions('en'));
        $manager->persist($this->generateCardifRemun('en'));
        $manager->persist($this->generateNodeNews('en'));

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 52;
    }

    /**
     * Generate a node
     *
     * @param array $params
     *
     * @return Node
     */
    protected function generateNode($params)
    {
        $node = new Node();
        $node->setNodeId($params['nodeId']);
        $node->setNodeType('page');
        $node->setSiteId('3');
        $node->setParentId($params['parentId']);
        $node->setAlias($params['alias']);
        $node->setPath($params['path']);
        $node->setName($params['name']);
        $node->setVersion(1);
        $node->setLanguage($params['language']);
        $node->setStatus($this->getReference('status-published'));
        $node->setDeleted(false);
        $node->setTemplateId('template_main');
        $node->setTheme($this->getReference('echonext'));
        $node->setInMenu($params['inMenu']);
        $node->setInFooter($params['inFooter']);

        return $node;
    }

    /**
     * Generate a specific block
     *
     * @param string $blockType
     * @param string $blockLabel
     * @param int    $nodeId
     * @param string $areaId
     *
     * @return Block
     */
    protected function generateBlock($blockType, $blockLabel, $nodeId, $areaId)
    {
        $block = new Block();
        $block->setLabel($blockLabel);
        $block->setComponent($blockType);
        $block->addArea(array('nodeId' => $nodeId, 'areaId' => $areaId));

        return $block;
    }

    /**
     * Generate language block
     *
     * @param $areaId
     * @param int $nodeId
     *
     * @return Block
     */
    protected function generateBlockLang($areaId, $nodeId = 0)
    {
        $blockLang = $this->generateBlock('language_list', 'Language', $nodeId, $areaId);
        $blockLang->setAttributes(array(
            'class' => 'lang',
            'id' => 'lang'
        ));

        return $blockLang;
    }

    /**
     * Generate a login block
     *
     * @param sting $blockLabel
     * @param int   $nodeId
     * @param string $areaId
     *
     * @return Block
     */
    protected function generateBlockLogin($blockLabel, $areaId, $nodeId = 0)
    {
        $blockLogin = $this->generateBlock('login', $blockLabel, $nodeId, $areaId);

        return $blockLogin;
    }

    /**
     * Generate Menu Block
     *
     * @param $blockLabel
     * @param $areaId
     * @param int $nodeId
     *
     * @return Block
     */
    protected function generateBlockMenu($blockLabel, $areaId, $nodeId = 0)
    {
        $menuBlock = $this->generateBlock('menu', $blockLabel, $nodeId, $areaId);
        $menuBlock->setAttributes(array(
            'class' => 'menu',
            'id' => 'menu',
        ));

        return $menuBlock;
    }

    /**
     * Generate a Carrousel
     *
     * @param $blockLabel
     * @param $areaId
     * @param int $nodeId
     *
     * @return Block
     */
    protected function generateBlockCarrousel($carouselId, $blockLabel, $areaId, $nodeId = 0)
    {
        $carrouselBlock = $this->generateBlock('carrousel', $blockLabel, $nodeId, $areaId);
        $carrouselBlock->setAttributes(array(
            'pictures' => array(
                array('src' => "/bundles/fakeapptheme/themes/echonext/img/carroussel/01.jpg"),
                array('src' => "/bundles/fakeapptheme/themes/echonext/img/carroussel/02.jpg"),
                array('src' => "/bundles/fakeapptheme/themes/echonext/img/carroussel/03.jpg"),
                array('src' => "/bundles/fakeapptheme/themes/echonext/img/carroussel/04.jpg"),
            ),
            'width' => "978px",
            'height' => "300px",
            'carrousel_id' => $carouselId,
        ));

        return $carrouselBlock;
    }

    /**
     * Generate a Wysiwyg block
     *
     * @param string $blockLabel
     * @param string $htmlContent
     * @param string $areaId
     * @param int    $nodeId
     *
     * @return Block
     */
    protected function generateBlockWysiwyg($blockLabel, $htmlContent, $areaId, $nodeId = 0)
    {
        $wysiwygBlock = $this->generateBlock('tiny_mce_wysiwyg', $blockLabel, $nodeId, $areaId);
        $wysiwygBlock->setAttributes(array('htmlContent' => $htmlContent));

        return $wysiwygBlock;
    }

    /**
     * Generate a list of Content
     *
     * @param string $class
     * @param string $url
     * @param string $blockLabel
     * @param string $areaId
     * @param string $nodeId
     * @param int    $nbCharacters
     *
     * @return Block
     */
    protected function generateBlockContentList($class, $url, $blockLabel, $areaId, $nodeId, $nbCharacters = 0)
    {
        $contentList = $this->generateBlock('content_list', $blockLabel, $nodeId, $areaId);
        $contentList->setAttributes(array(
            'contentType' => 'news',
            'id' => 'contentNewsList',
            'class' => $class,
            'url' => $url,
            'characterNumber' => $nbCharacters
        ));

        return $contentList;
    }

    /**
     * Generate a content
     *
     * @param string $divClass
     * @param string $blockLabel
     * @param string $areaId
     * @param int    $nodeId
     *
     * @return Block
     */
    protected function generateBlockContent($divClass, $blockLabel, $areaId, $nodeId = 0)
    {
        $contentBlock = $this->generateBlock('content', $blockLabel, $nodeId, $areaId);
        $contentBlock->setAttributes(array(
            'id' => 'contentNews',
            'class' => $divClass,
        ));

        return $contentBlock;
    }

    /**
     * Generate a sub menu
     *
     * @param string $class
     * @param string $idmenu
     * @param string $nbLevel
     * @param string $node
     * @param string $blockLabel
     * @param string $areaId
     * @param int    $nodeId
     *
     * @return Block
     */
    protected function generateBlockSubMenu($class, $idmenu, $nbLevel, $node, $blockLabel, $areaId, $nodeId = 0)
    {
        $subMenuBlock = $this->generateBlock('sub_menu', $blockLabel, $nodeId, $areaId);
        $subMenuBlock->setAttributes(array(
            'class' => $class,
            'id' => $idmenu,
            'nbLevel' => $nbLevel,
            'node' => $node,
        ));

        return $subMenuBlock;
    }

    /**
     * Generate an Area
     *
     * @param string $areaLabel
     * @param string $areaId
     * @param array  $blocks
     *
     * @return Area
     */
    protected function generateArea($areaLabel, $areaId, $blocks)
    {
        $area = new Area();
        $area->setLabel($areaLabel);
        $area->setAreaId($areaId);
        $area->setBlocks($blocks);

        return $area;
    }

    /**
     * Generate Footer Block
     *
     * @param $blockLabel
     * @param $areaId
     * @param int $nodeId
     *
     * @return Block
     */
    protected function generateFooterBlock($blockLabel, $areaId, $nodeId = 0)
    {
        $footerBlock = $this->generateBlock('footer', $blockLabel, $nodeId, $areaId);
        $footerBlock->setAttributes(array(
            'id' => 'footer_content',
            'class' => 'footer',
        ));

        return $footerBlock;
    }

    /**
     * @return Node
     */
    protected function generateNodeTransverse($language)
    {
        // Header
        $languageBlock = $this->generateBlockLang('main');
        $search = $this->generateBlockWysiwyg('Search', "<div class=search><input type='text'><button type='submit'>Rechercher</button></div>", 'main');
        $logoBlock = $this->generateBlockWysiwyg('Logo', "<a href='#' id='myLogo'> <img src='http://media.phporchestra.inte/echonext-head_logo.png' /> </a><img src='http://media.phporchestra.inte/echonext-head_img.jpg' class='bg-header'/>", 'main');
        $loginBlock = $this->generateBlockLogin('Login', 'main');
        $menuBlock = $this->generateBlockMenu('Menu', 'main');
        $footerBlock = $this->generateFooterBlock('Footer', 'main');

        $mainArea = $this->generateArea('main', 'main',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 0),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 1),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 2),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 3),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 4),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 5),
            )
        );

        // Generation of the home node
        $node = $this->generateNode(array(
            'nodeId' => NodeInterface::TRANSVERSE_NODE_ID,
            'parentId' => '-',
            'path' => '-',
            'name' => NodeInterface::TRANSVERSE_NODE_ID,
            'alias' => NodeInterface::TRANSVERSE_NODE_ID,
            'inMenu' => false,
            'inFooter' => false,
            'language' => $language,
        ));
        $node->setNodeType(NodeInterface::TYPE_GENERAL);

        $node->addArea($mainArea);
        $node->addBlock($languageBlock);
        $node->addBlock($loginBlock);
        $node->addBlock($logoBlock);
        $node->addBlock($search);
        $node->addBlock($menuBlock);
        $node->addBlock($footerBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateNodeHome($language)
    {
        // Header
        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 0),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 1),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 2),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 3),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 4),
            )
        );
        $headerArea->setBoDirection('v');

        // Main
        $descBlock = $this->generateBlockWysiwyg('Home', '<h1>Bienvenue sur le site de demo Echonext.</h1>', 'main');
        $carrouselBlock = $this->generateBlockCarrousel('slider1_container', 'Carrousel', 'main');
        $newsList = $this->generateBlockContentList('content-list', 'news', 'News 6', 'main', 70);

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1),
                array('nodeId' => 0, 'blockId' => 2),
            )
        );

        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 5),
            )
        );

        // Generation of the home node
        $node = $this->generateNode(array(
            'nodeId' => NodeInterface::ROOT_NODE_ID,
            'parentId' => '-',
            'path' => '-',
            'name' => 'Home',
            'alias' => 'home',
            'url' => 'home',
            'inMenu' => true,
            'inFooter' => true,
            'language' => $language,
        ));

        $node->addArea($headerArea);

        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($carrouselBlock);
        $node->addBlock($newsList);

        $node->addArea($footerArea);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateNodeNews($language)
    {
        // Header
        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 0),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 1),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 2),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 3),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 4),
            )
        );
        $headerArea->setBoDirection('v');

        // Main
        $newsList = $this->generateBlockContent('news', 'News', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 'news', 'blockId' => 0),
            )
        );

        // Footer
        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 5),
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'news',
            'parentId' => NodeInterface::ROOT_NODE_ID,
            'path' => 'news',
            'name' => 'News',
            'alias' => 'news',
            'url' => 'news',
            'inMenu' => false,
            'inFooter' => false,
            'language' => $language,
        ));

        $node->addArea($headerArea);
        $node->addArea($mainArea);
        $node->addArea($footerArea);

        $node->addBlock($newsList);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateEspaceBDDF($language)
    {
        // Header
        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 0),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 1),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 2),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 3),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 4),
            )
        );
        $headerArea->setBoDirection('v');

        // Main
        $titleBlock = $this->generateBlockWysiwyg('BDDF', '<h1>Page Espace BDDF</h1>', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 'espace_bddf', 'blockId' => 0),
            )
        );

        // Footer
        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 5),
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'espace_bddf',
            'parentId' => NodeInterface::ROOT_NODE_ID,
            'path' => 'espace-bddf',
            'name' => 'Espace BDDF',
            'alias' => 'espace-bddf',
            'url' => 'espace-bddf',
            'inMenu' => true,
            'inFooter' => true,
            'language' => $language,
        ));

        $node->addArea($headerArea);
        $node->addArea($mainArea);
        $node->addArea($footerArea);

        $node->addBlock($titleBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateEspaceCardif($language)
    {
        // Header
        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 0),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 1),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 2),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 3),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 4),
            )
        );
        $headerArea->setBoDirection('v');

        // Main
        $subMenu = $this->generateBlockSubMenu('left_menu', 'cardif_left_menu', 2, 'espace_Cardif', 'Sub Menu', 'left_menu');
        $titleBlock = $this->generateBlockWysiwyg('Cardif', "<h1>Bienvenue sur l'espace de cardif</h1>", 'main');
        $bodyBlock = $this->generateBlockWysiwyg('Body cardif', '<div class="body-espace-cardif"><p>BNP Paribas cardif est l\'un des François Villeroy de Galhau,
            Directeur Général Délégué de BNP Paribas répond à nos questions. Cras non dui id neque mattis molestie. Quisque feugiat metus in est aliquet, nec convallis
            ante blandit. Suspendisse tincidunt tortor et tellus eleifend bibendum. Fusce fringilla mauris dolor, quis tempus diam tempus eu. Morbi enim orci, aliquam at
            sapien eu, dignissim commodo enim. Nulla ultricies erat non facilisis feugiat. Quisque fringilla ante lacus, vitae viverra magna aliquam non. Pellentesque
            quis diam suscipit, tincidunt felis eget, mollis mauris. Nulla facilisi.</p><p>Nunc tincidunt pellentesque suscipit. Donec tristique massa at turpis fringilla,
            non aliquam ante luctus. Nam in felis tristique, scelerisque magna eget, sagittis purus. Maecenas malesuada placerat rutrum. Vestibulum sem urna, pharetra et
            fermentum a, iaculis quis augue. Ut ac neque mauris. In vel risus dui. Fusce lacinia a velit vitae condimentum.</p></div>', 'main');

        $leftMenu = $this->generateArea('Left menu', 'left_menu', array(
            array('nodeId' => 'espace_Cardif', 'blockId' => 0),));
        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 'espace_Cardif', 'blockId' => 1),
                array('nodeId' => 'espace_Cardif', 'blockId' => 2),
            )
        );
        $bodyArea = $this->generateArea('Body', 'body', array());
        $bodyArea->setBoDirection('v');
        $bodyArea->addArea($leftMenu);
        $bodyArea->addArea($mainArea);

        // Footer
        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 5),
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'espace_Cardif',
            'parentId' => NodeInterface::ROOT_NODE_ID,
            'path' => 'espace-cardif',
            'name' => 'Espace Cardif',
            'alias' => 'espace-cardif',
            'url' => 'espace-cardif',
            'inMenu' => true,
            'inFooter' => true,
            'language' => $language,
        ));

        $node->addArea($headerArea);
        $node->addArea($bodyArea);
        $node->addArea($footerArea);

        $node->addBlock($subMenu);
        $node->addBlock($titleBlock);
        $node->addBlock($bodyBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateEspaceArval($language)
    {
        // Header
        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 0),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 1),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 2),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 3),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 4),
            )
        );
        $headerArea->setBoDirection('v');

        // Main
        $titleBlock = $this->generateBlockWysiwyg('BDDF', '<h1>Page Espace Arval</h1>', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 'espace_Arval', 'blockId' => 0),
            )
        );

        // Footer
        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 5),
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'espace_Arval',
            'parentId' => NodeInterface::ROOT_NODE_ID,
            'path' => 'espace-arval',
            'name' => 'Espace Arval',
            'alias' => 'espace-arval',
            'url' => 'espace-arval',
            'inMenu' => true,
            'inFooter' => true,
            'language' => $language,
        ));

        $node->addArea($headerArea);
        $node->addArea($mainArea);
        $node->addArea($footerArea);

        $node->addBlock($titleBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateEspaceXXX($language)
    {
        // Header
        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 0),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 1),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 2),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 3),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 4),
            )
        );
        $headerArea->setBoDirection('v');

        // Main
        $titleBlock = $this->generateBlockWysiwyg('BDDF', '<h1>Page Espace XXX</h1>', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 'espace_XXX', 'blockId' => 0),
            )
        );

        // Footer
        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 5),
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'espace_XXX',
            'parentId' => NodeInterface::ROOT_NODE_ID,
            'path' => 'espace-xxx',
            'name' => 'Espace XXX',
            'alias' => 'espace-xxx',
            'url' => 'espace-xxx',
            'inMenu' => true,
            'inFooter' => true,
            'language' => $language,
        ));

        $node->addArea($headerArea);
        $node->addArea($mainArea);
        $node->addArea($footerArea);

        $node->addBlock($titleBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateCardifBienvenu($language)
    {
        // Header
        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 0),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 1),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 2),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 3),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 4),
            )
        );
        $headerArea->setBoDirection('v');

        // Main
        $subMenu = $this->generateBlockSubMenu('left_menu', 'cardif_left_menu', 2, 'espace_Cardif', 'Sub Menu', 'left_menu');
        $titleBlock = $this->generateBlockWysiwyg('BDDF', '<h1>Bienvenue sur l\'espace Cardif</h1>', 'main');
        $bodyBlock = $this->generateBlockWysiwyg('Body cardif', '<div class="body-espace-cardif"><p>BNP Paribas cardif est l\'un des François Villeroy de Galhau,
            Directeur Général Délégué de BNP Paribas répond à nos questions. Cras non dui id neque mattis molestie. Quisque feugiat metus in est aliquet, nec convallis
            ante blandit. Suspendisse tincidunt tortor et tellus eleifend bibendum. Fusce fringilla mauris dolor, quis tempus diam tempus eu. Morbi enim orci, aliquam at
            sapien eu, dignissim commodo enim. Nulla ultricies erat non facilisis feugiat. Quisque fringilla ante lacus, vitae viverra magna aliquam non. Pellentesque
            quis diam suscipit, tincidunt felis eget, mollis mauris. Nulla facilisi.</p><p>Nunc tincidunt pellentesque suscipit. Donec tristique massa at turpis fringilla,
            non aliquam ante luctus. Nam in felis tristique, scelerisque magna eget, sagittis purus. Maecenas malesuada placerat rutrum. Vestibulum sem urna, pharetra et
            fermentum a, iaculis quis augue. Ut ac neque mauris. In vel risus dui. Fusce lacinia a velit vitae condimentum.</p></div>', 'main');

        $leftMenu = $this->generateArea('Left menu', 'left_menu', array(
            array('nodeId' => 'cardif_bienvenu', 'blockId' => 0),));
        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 'cardif_bienvenu', 'blockId' => 1),
                array('nodeId' => 'cardif_bienvenu', 'blockId' => 2),
            )
        );
        $bodyArea = $this->generateArea('Body', 'body', array());
        $bodyArea->setBoDirection('v');
        $bodyArea->addArea($leftMenu);
        $bodyArea->addArea($mainArea);

        // Footer
        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 5),
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'cardif_bienvenu',
            'parentId' => 'espace_Cardif',
            'path' => 'bienvenu',
            'name' => 'Bienvenu',
            'alias' => 'bienvenu',
            'url' => 'bienvenu',
            'inMenu' => false,
            'inFooter' => false,
            'language' => $language,
        ));

        $node->addArea($headerArea);
        $node->addArea($bodyArea);
        $node->addArea($footerArea);

        $node->addBlock($subMenu);
        $node->addBlock($titleBlock);
        $node->addBlock($bodyBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateCardifActualite($language)
    {
        // Header
        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 0),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 1),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 2),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 3),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 4),
            )
        );
        $headerArea->setBoDirection('v');

        // Main
        $subMenu = $this->generateBlockSubMenu('left_menu', 'cardif_left_menu', 2, 'espace_Cardif', 'Sub Menu', 'left_menu');
        $titleBlock = $this->generateBlockWysiwyg('BDDF', '<h1>Page actualité Cardif</h1>', 'main');
        $bodyBlock = $this->generateBlockWysiwyg('Body cardif', '<div class="body-espace-cardif"><p>BNP Paribas cardif est l\'un des François Villeroy de Galhau,
            Directeur Général Délégué de BNP Paribas répond à nos questions. Cras non dui id neque mattis molestie. Quisque feugiat metus in est aliquet, nec convallis
            ante blandit. Suspendisse tincidunt tortor et tellus eleifend bibendum. Fusce fringilla mauris dolor, quis tempus diam tempus eu. Morbi enim orci, aliquam at
            sapien eu, dignissim commodo enim. Nulla ultricies erat non facilisis feugiat. Quisque fringilla ante lacus, vitae viverra magna aliquam non. Pellentesque
            quis diam suscipit, tincidunt felis eget, mollis mauris. Nulla facilisi.</p><p>Nunc tincidunt pellentesque suscipit. Donec tristique massa at turpis fringilla,
            non aliquam ante luctus. Nam in felis tristique, scelerisque magna eget, sagittis purus. Maecenas malesuada placerat rutrum. Vestibulum sem urna, pharetra et
            fermentum a, iaculis quis augue. Ut ac neque mauris. In vel risus dui. Fusce lacinia a velit vitae condimentum.</p></div>', 'main');

        $leftMenu = $this->generateArea('Left menu', 'left_menu', array(
            array('nodeId' => 'cardif_actualite', 'blockId' => 0),));
        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 'cardif_actualite', 'blockId' => 1),
                array('nodeId' => 'cardif_actualite', 'blockId' => 2),
            )
        );
        $bodyArea = $this->generateArea('Body', 'body', array());
        $bodyArea->setBoDirection('v');
        $bodyArea->addArea($leftMenu);
        $bodyArea->addArea($mainArea);

        // Footer
        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 5),
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'cardif_actualite',
            'parentId' => 'espace_Cardif',
            'path' => 'actualite',
            'name' => 'Actualité',
            'alias' => 'actualite',
            'url' => 'actualite',
            'inMenu' => true,
            'inFooter' => true,
            'language' => $language,
        ));

        $node->addArea($headerArea);
        $node->addArea($bodyArea);
        $node->addArea($footerArea);

        $node->addBlock($subMenu);
        $node->addBlock($titleBlock);
        $node->addBlock($bodyBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateCardifMissions($language)
    {
        // Header
        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 0),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 1),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 2),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 3),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 4),
            )
        );
        $headerArea->setBoDirection('v');

        // Main
        $subMenu = $this->generateBlockSubMenu('left_menu', 'cardif_left_menu', 2, 'espace_Cardif', 'Sub Menu', 'left_menu');
        $titleBlock = $this->generateBlockWysiwyg('BDDF', '<h1>Page Missions Cardif</h1>', 'main');
        $bodyBlock = $this->generateBlockWysiwyg('Body cardif', '<div class="body-espace-cardif"><p>BNP Paribas cardif est l\'un des François Villeroy de Galhau,
            Directeur Général Délégué de BNP Paribas répond à nos questions. Cras non dui id neque mattis molestie. Quisque feugiat metus in est aliquet, nec convallis
            ante blandit. Suspendisse tincidunt tortor et tellus eleifend bibendum. Fusce fringilla mauris dolor, quis tempus diam tempus eu. Morbi enim orci, aliquam at
            sapien eu, dignissim commodo enim. Nulla ultricies erat non facilisis feugiat. Quisque fringilla ante lacus, vitae viverra magna aliquam non. Pellentesque
            quis diam suscipit, tincidunt felis eget, mollis mauris. Nulla facilisi.</p><p>Nunc tincidunt pellentesque suscipit. Donec tristique massa at turpis fringilla,
            non aliquam ante luctus. Nam in felis tristique, scelerisque magna eget, sagittis purus. Maecenas malesuada placerat rutrum. Vestibulum sem urna, pharetra et
            fermentum a, iaculis quis augue. Ut ac neque mauris. In vel risus dui. Fusce lacinia a velit vitae condimentum.</p></div>', 'main');

        $leftMenu = $this->generateArea('Left menu', 'left_menu', array(
            array('nodeId' => 'cardif_missions', 'blockId' => 0),));
        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 'cardif_missions', 'blockId' => 1),
                array('nodeId' => 'cardif_missions', 'blockId' => 2),
            )
        );
        $bodyArea = $this->generateArea('Body', 'body', array());
        $bodyArea->setBoDirection('v');
        $bodyArea->addArea($leftMenu);
        $bodyArea->addArea($mainArea);

        // Footer
        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 5),
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'cardif_missions',
            'parentId' => 'espace_Cardif',
            'path' => 'missions',
            'name' => 'Mission',
            'alias' => 'missions',
            'url' => 'missions',
            'inMenu' => true,
            'inFooter' => true,
            'language' => $language,
        ));

        $node->addArea($headerArea);
        $node->addArea($bodyArea);
        $node->addArea($footerArea);

        $node->addBlock($subMenu);
        $node->addBlock($titleBlock);
        $node->addBlock($bodyBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateCardifRemun($language)
    {
        // Header
        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 0),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 1),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 2),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 3),
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 4),
            )
        );
        $headerArea->setBoDirection('v');

        // Main
        $subMenu = $this->generateBlockSubMenu('left_menu', 'cardif_left_menu', 2, 'espace_Cardif', 'Sub Menu', 'left_menu');
        $titleBlock = $this->generateBlockWysiwyg('BDDF', '<h1>Page Cardif Rémunération</h1>', 'main');
        $bodyBlock = $this->generateBlockWysiwyg('Body cardif', '<div class="body-espace-cardif"><p>BNP Paribas cardif est l\'un des François Villeroy de Galhau,
            Directeur Général Délégué de BNP Paribas répond à nos questions. Cras non dui id neque mattis molestie. Quisque feugiat metus in est aliquet, nec convallis
            ante blandit. Suspendisse tincidunt tortor et tellus eleifend bibendum. Fusce fringilla mauris dolor, quis tempus diam tempus eu. Morbi enim orci, aliquam at
            sapien eu, dignissim commodo enim. Nulla ultricies erat non facilisis feugiat. Quisque fringilla ante lacus, vitae viverra magna aliquam non. Pellentesque
            quis diam suscipit, tincidunt felis eget, mollis mauris. Nulla facilisi.</p><p>Nunc tincidunt pellentesque suscipit. Donec tristique massa at turpis fringilla,
            non aliquam ante luctus. Nam in felis tristique, scelerisque magna eget, sagittis purus. Maecenas malesuada placerat rutrum. Vestibulum sem urna, pharetra et
            fermentum a, iaculis quis augue. Ut ac neque mauris. In vel risus dui. Fusce lacinia a velit vitae condimentum.</p></div>', 'main');

        $leftMenu = $this->generateArea('Left menu', 'left_menu', array(
            array('nodeId' => 'cardif_remunerations', 'blockId' => 0),));
        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 'cardif_remunerations', 'blockId' => 1),
                array('nodeId' => 'cardif_remunerations', 'blockId' => 2),
            )
        );
        $bodyArea = $this->generateArea('Body', 'body', array());
        $bodyArea->setBoDirection('v');
        $bodyArea->addArea($leftMenu);
        $bodyArea->addArea($mainArea);

        // Footer
        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => NodeInterface::TRANSVERSE_NODE_ID, 'blockId' => 5),
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'cardif_remunerations',
            'parentId' => 'espace_Cardif',
            'path' => 'remunarations-variables',
            'name' => 'Remunerations',
            'alias' => 'remunarations-variables',
            'url' => 'remunarations-variables',
            'inMenu' => true,
            'inFooter' => true,
            'language' => $language,
        ));

        $node->addArea($headerArea);
        $node->addArea($bodyArea);
        $node->addArea($footerArea);

        $node->addBlock($subMenu);
        $node->addBlock($titleBlock);
        $node->addBlock($bodyBlock);

        return $node;
    }
}
