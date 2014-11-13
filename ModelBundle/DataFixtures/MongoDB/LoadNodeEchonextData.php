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
        $manager->persist($this->generateNodeHome());
        $manager->persist($this->generateEspaceBDDF());
        $manager->persist($this->generateEspaceCardif());
        $manager->persist($this->generateEspaceArval());
        $manager->persist($this->generateEspaceXXX());
        $manager->persist($this->generateCardifBienvenu());
        $manager->persist($this->generateCardifActualite());
        $manager->persist($this->generateCardifMissions());
        $manager->persist($this->generateCardifRemun());
        $manager->persist($this->generateNodeNews());

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
        $node->setLanguage('fr');
        $node->setStatus($this->getReference('status-published'));
        $node->setDeleted(false);
        $node->setTemplateId('template_main');
        $node->setTheme('echonext');
        $node->setInMenu(true);
        $node->setInFooter(true);

        return $node;
    }

    /**
     * Generate a specific block
     * 
     * @param string $blockType
     * @param string $blockLabel
     * @param int|string $nodeId
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
     * Generate a login block
     *
     * @param sting $blockLabel
     * @param int| string $nodeId
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
            'class' => array(
                'div' => 'menu',
                'ul' => 'menu_ul',
                'link' => 'menu_link'
            ),
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
    protected function generateBlockCarrousel($carousel_id, $blockLabel, $areaId, $nodeId = 0)
    {
        $carrouselBlock = $this->generateBlock('carrousel', $blockLabel, $areaId, $nodeId);
        $carrouselBlock->setAttributes(array(
            'pictures' => array(
                array('src' => "/bundles/fakeapptheme/themes/echonext/img/carroussel/01.jpg"),
                array('src' => "/bundles/fakeapptheme/themes/echonext/img/carroussel/02.jpg"),
                array('src' => "/bundles/fakeapptheme/themes/echonext/img/carroussel/03.jpg"),
                array('src' => "/bundles/fakeapptheme/themes/echonext/img/carroussel/04.jpg"),
            ),
            'width' => "978px",
            'height' => "300px",
            'carrousel_id' => $carousel_id,
        ));

        return $carrouselBlock;
    }

    /**
     * Generate a Wysiwyg block
     * 
     * @param string $blockLabel
     * @param string $htmlContent
     * @param int|string $nodeId
     * @param string $areaId
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
     * @param $blockLabel
     * @param $areaId
     * @param int $nodeId
     * @param $divClass
     * @param $each
     * @param $titleClass
     * @param $url
     *
     * @return Block
     */
    protected function generateBlockContentList($divClass, $each, $titleClass, $url, $blockLabel, $areaId, $nodeId = 0)
    {
        $contentList = $this->generateBlock('content_list', $blockLabel, $nodeId, $areaId);
        $contentList->setAttributes(array(
            'contentType' => 'news',
            'id' => 'contentNewsList',
            'class' => array(
                'div' => $divClass,
                'each' => $each,
                'title' => $titleClass
            ),
            'url' => $url,
        ));

        return $contentList;
    }

    /**
     * Generate a content
     * @param $divClass
     * @param $titleClass
     * @param $contentClass
     * @param $blockLabel
     * @param $areaId
     * @param int $nodeId
     *
     * @return Block
     */
    protected function generateBlockContent($divClass, $titleClass, $contentClass, $blockLabel, $areaId, $nodeId = 0)
    {
        $contentBlock = $this->generateBlock('content', $blockLabel, $nodeId, $areaId);
        $contentBlock->setAttributes(array(
           'id' => 'contentNews',
            'class' => array(
                'div' => $divClass,
                'title' => $titleClass,
                'content' => $contentClass
            )
        ));

        return $contentBlock;
    }

    /**
     * Generate an Area
     * 
     * @param string $areaLabel
     * @param string $areaId
     * @param array $blocks
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
            'class' => array(
                'div' => 'footer',
                'ul' => 'ul_footer',
                'link' => 'ul_link'
            )
        ));

        return $footerBlock;
    }


    /**
     * @return Node
     */
    protected function generateNodeHome()
    {
        // Header
        $search = $this->generateBlockWysiwyg('Search', "<div class=search><input type='text'><button type='submit'>Rechercher</button></div>", 'header');
        $logoBlock = $this->generateBlockWysiwyg('Logo', "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/echonext/img/head_logo.png' /> </a><img src='/bundles/fakeapptheme/themes/echonext/img/head_img.jpg' class='bg-header'/>", 'header');
        $loginBlock = $this->generateBlockLogin('Login', 'header');
        $menuBlock = $this->generateBlockMenu('Menu', 'header');

        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1),
                array('nodeId' => 0, 'blockId' => 2),
                array('nodeId' => 0, 'blockId' => 3),
            )
        );

        // Main
        $descBlock = $this->generateBlockWysiwyg('Home', '<h1>Bienvenue sur le site de demo Echonext.</h1>', 'main');
        $carrouselBlock = $this->generateBlockCarrousel('slider1_container', 'Carrousel', 'main');
        $newsList = $this->generateBlockContentList('content-list', 'each_news', 'title_news', 'news', 'News 6', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 4),
                array('nodeId' => 0, 'blockId' => 5),
                array('nodeId' => 0, 'blockId' => 6),
            )
        );


        // Footer
        $footerBlock = $this->generateFooterBlock('Footer', 'footer');

        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => 0, 'blockId' => 7),
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
        ));

        $node->addArea($headerArea);
        $node->addBlock($loginBlock);
        $node->addBlock($logoBlock);
        $node->addBlock($search);
        $node->addBlock($menuBlock);

        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($carrouselBlock);
        $node->addBlock($newsList);

        $node->addArea($footerArea);
        $node->addBlock($footerBlock);
        return $node;
    }

    /**
     * @return Node
     */
    protected function generateNodeNews()
    {
        // Header
        $search = $this->generateBlockWysiwyg('Search', "<div class=search><input type='text'><button type='submit'>Rechercher</button></div>", 'header');
        $logoBlock = $this->generateBlockWysiwyg('Logo', "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/echonext/img/head_logo.png' /> </a><img src='/bundles/fakeapptheme/themes/echonext/img/head_img.jpg' class='bg-header'/>", 'header');
        $loginBlock = $this->generateBlockLogin('Login', 'header');
        $menuBlock = $this->generateBlockMenu('Menu', 'header');

        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1),
                array('nodeId' => 0, 'blockId' => 2),
                array('nodeId' => 0, 'blockId' => 3),
            )
        );

        // Main
        $newsList = $this->generateBlockContent('news', 'title_news', 'section', 'News', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 4),
            )
        );

        // Footer
        $footerBlock = $this->generateFooterBlock('Footer', 'footer');

        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => 0, 'blockId' => 5),
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'news',
            'parentId' => 'espace_Cardif',
            'path' => 'news',
            'name' => 'News',
            'alias' => 'news',
            'url' => 'news',
        ));

        $node->addArea($headerArea);
        $node->addBlock($loginBlock);
        $node->addBlock($logoBlock);
        $node->addBlock($search);
        $node->addBlock($menuBlock);

        $node->addArea($mainArea);
        $node->addBlock($newsList);

        $node->addArea($footerArea);
        $node->addBlock($footerBlock);

        return $node;
    }
    
    /**
     * @return Node
     */
    protected function generateEspaceBDDF()
    {
        // Header
        $search = $this->generateBlockWysiwyg('Search', "<div class=search><input type='text'><button type='submit'>Rechercher</button></div>", 'header');
        $logoBlock = $this->generateBlockWysiwyg('Logo', "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/echonext/img/head_logo.png' /> </a><img src='/bundles/fakeapptheme/themes/echonext/img/head_img.jpg' class='bg-header'/>", 'header');
        $loginBlock = $this->generateBlockLogin('Login', 'header');
        $menuBlock = $this->generateBlockMenu('Menu', 'header');

        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1),
                array('nodeId' => 0, 'blockId' => 2),
                array('nodeId' => 0, 'blockId' => 3),
            )
        );

        // Main
        $titleBlock = $this->generateBlockWysiwyg('BDDF', '<h1>Page Espace BDDF</h1>', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 4),
            )
        );

        // Footer
        $footerBlock = $this->generateFooterBlock('Footer', 'footer');

        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => 0, 'blockId' => 5),
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'espace_bddf',
            'parentId' => NodeInterface::ROOT_NODE_ID,
            'path' => 'espace-bddf',
            'name' => 'Espace BDDF',
            'alias' => 'espace-bddf',
            'url' => 'espace-bddf',
        ));

        $node->addArea($headerArea);
        $node->addBlock($loginBlock);
        $node->addBlock($logoBlock);
        $node->addBlock($search);
        $node->addBlock($menuBlock);

        $node->addArea($mainArea);
        $node->addBlock($titleBlock);

        $node->addArea($footerArea);
        $node->addBlock($footerBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateEspaceCardif()
    {
        // Header
        $search = $this->generateBlockWysiwyg('Search', "<div class=search><input type='text'><button type='submit'>Rechercher</button></div>", 'header');
        $logoBlock = $this->generateBlockWysiwyg('Logo', "<a href='#' id='myLogo'> <img src='/bundles/fakeapptheme/themes/echonext/img/head_logo.png' /> </a><img src='/bundles/fakeapptheme/themes/echonext/img/head_img.jpg' class='bg-header'/>", 'header');
        $loginBlock = $this->generateBlockLogin('Login', 'header');
        $menuBlock = $this->generateBlockMenu('Menu', 'header');

        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1),
                array('nodeId' => 0, 'blockId' => 2),
                array('nodeId' => 0, 'blockId' => 3),
            )
        );

        // Main
        $titleBlock = $this->generateBlockWysiwyg('Cardif', "<h1>Bienvenue sur l'espace de cardif</h1>", 'main');
        $bodyBlock = $this->generateBlockWysiwyg('Body cardif', '<div class="body-espace-cardif"><p>BNP Paribas cardif est l\'un des François Villeroy de Galhau,
            Directeur Général Délégué de BNP Paribas répond à nos questions. Cras non dui id neque mattis molestie. Quisque feugiat metus in est aliquet, nec convallis
            ante blandit. Suspendisse tincidunt tortor et tellus eleifend bibendum. Fusce fringilla mauris dolor, quis tempus diam tempus eu. Morbi enim orci, aliquam at
            sapien eu, dignissim commodo enim. Nulla ultricies erat non facilisis feugiat. Quisque fringilla ante lacus, vitae viverra magna aliquam non. Pellentesque
            quis diam suscipit, tincidunt felis eget, mollis mauris. Nulla facilisi.</p><p>Nunc tincidunt pellentesque suscipit. Donec tristique massa at turpis fringilla,
            non aliquam ante luctus. Nam in felis tristique, scelerisque magna eget, sagittis purus. Maecenas malesuada placerat rutrum. Vestibulum sem urna, pharetra et
            fermentum a, iaculis quis augue. Ut ac neque mauris. In vel risus dui. Fusce lacinia a velit vitae condimentum.</p></div>', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 4),
                array('nodeId' => 0, 'blockId' => 5),
            )
        );

        // Footer
        $footerBlock = $this->generateFooterBlock('Footer', 'footer');

        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => 0, 'blockId' => 6),
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'espace_Cardif',
            'parentId' => NodeInterface::ROOT_NODE_ID,
            'path' => 'espace-cardif',
            'name' => 'Espace Cardif',
            'alias' => 'espace-cardif',
            'url' => 'espace-cardif',
        ));

        $node->addArea($headerArea);
        $node->addBlock($loginBlock);
        $node->addBlock($logoBlock);
        $node->addBlock($search);
        $node->addBlock($menuBlock);

        $node->addArea($mainArea);
        $node->addBlock($titleBlock);
        $node->addBlock($bodyBlock);

        $node->addArea($footerArea);
        $node->addBlock($footerBlock);

        return $node;

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateEspaceArval()
    {
        $descBlock = $this->generateBlockWysiwyg('Arval', '<h1>Page Espace Arval</h1>', 'main');
        $loginBlock = $this->generateBlockLogin('Login', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1)
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'espace_Arval',
            'parentId' => NodeInterface::ROOT_NODE_ID,
            'path' => 'espace-arval',
            'name' => 'Espace Arval',
            'alias' => 'espace-arval',
            'url' => 'espace-arval',
        ));
        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($loginBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateEspaceXXX()
    {
        $descBlock = $this->generateBlockWysiwyg('XXX', '<h1>Page Espace XXX</h1>', 'main');
        $loginBlock = $this->generateBlockLogin('Login', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1)
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'espace_XXX',
            'parentId' => NodeInterface::ROOT_NODE_ID,
            'path' => 'espace-xxx',
            'name' => 'Espace XXX',
            'alias' => 'espace-xxx',
            'url' => 'espace-xxx',
        ));
        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($loginBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateCardifBienvenu()
    {
        $descBlock = $this->generateBlockWysiwyg('Bienvenu', '<h1>Bienvenu sur l\'espace Cardif</h1>', 'main');
        $loginBlock = $this->generateBlockLogin('Login', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1)
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'cardif_bienvenu',
            'parentId' => 'espace_Cardif',
            'path' => 'bienvenu',
            'name' => 'Bienvenu',
            'alias' => 'bienvenu',
            'url' => 'bienvenu',
        ));
        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($loginBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateCardifActualite()
    {
        $descBlock = $this->generateBlockWysiwyg('Actualité', '<h1>Actualité de l\'espace Cardif</h1>', 'main');
        $loginBlock = $this->generateBlockLogin('Login', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1)
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'cardif_actualite',
            'parentId' => 'espace_Cardif',
            'path' => 'actualite',
            'name' => 'Actualité',
            'alias' => 'actualite',
            'url' => 'actualite',
        ));
        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($loginBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateCardifMissions()
    {
        $descBlock = $this->generateBlockWysiwyg('Missions', '<h1>Missions de l\'espace Cardif</h1>', 'main');
        $loginBlock = $this->generateBlockLogin('Login', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1)
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'cardif_missions',
            'parentId' => 'espace_Cardif',
            'path' => 'missions',
            'name' => 'Mission',
            'alias' => 'missions',
            'url' => 'missions',
        ));
        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($loginBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateCardifRemun()
    {
        $descBlock = $this->generateBlockWysiwyg('Rémunération', '<h1>Politique de rémunération variable</h1>', 'main');
        $loginBlock = $this->generateBlockLogin('Login', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1)
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'cardif_remunerations',
            'parentId' => 'espace_Cardif',
            'path' => 'remunarations-variables',
            'name' => 'Remunerations',
            'alias' => 'remunarations-variables',
            'url' => 'remunarations-variables',
        ));
        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($loginBlock);

        return $node;
    }
}
