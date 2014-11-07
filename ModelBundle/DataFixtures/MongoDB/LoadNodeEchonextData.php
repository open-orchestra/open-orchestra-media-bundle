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
     * @param $ulClass
     * @param $titleClass
     * @param $url
     *
     * @return Block
     */
    protected function generateBlockContentList($divClass, $ulClass, $titleClass, $url, $blockLabel, $areaId, $nodeId = 0)
    {
        $contentList = $this->generateBlock('content_list', $blockLabel, $nodeId, $areaId);
        $contentList->setAttributes(array(
            'contentType' => 'news',
            'id' => 'contentNewsList',
            'class' => array(
                'div' => $divClass,
                'ul' => $ulClass,
                'title' => $titleClass
            )
        ));

        return $contentList;
    }

    /**
     * Generate a content
     * @param $divClass
     * @param $ulClass
     * @param $titleClass
     * @param $contentClass
     * @param $blockLabel
     * @param $areaId
     * @param int $nodeId
     *
     * @return Block
     */
    protected function generateBlockContent($divClass, $ulClass, $titleClass, $contentClass, $blockLabel, $areaId, $nodeId = 0)
    {
        $contentBlock = $this->generateBlock('content', $blockLabel, $nodeId, $areaId);
        $contentBlock->setAttributes(array(
           'id' => 'contentNews',
            'class' => array(
                'div' => $divClass,
                'ul' => $ulClass,
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
     * Generate a div for clearing floats
     * @param $areaId
     *
     * @return Block
     */
    protected function generateClearBlock($areaId)
    {
        return $this->generateBlockWysiwyg('Clear', '<div class="clear" style="clear:both"></div>', $areaId);
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
        $clearHeader = $this->generateClearBlock('header');

        $headerArea = $this->generateArea('Header', 'header',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1),
                array('nodeId' => 0, 'blockId' => 2),
                array('nodeId' => 0, 'blockId' => 3),
                array('nodeId' => 0, 'blockId' => 4),
            )
        );

        // Main
        $descBlock = $this->generateBlockWysiwyg('Home', '<h1>Bienvenue sur le site de demo Echonext.</h1>', 'main');
        $carrouselBlock = $this->generateBlockCarrousel('slider1_container', 'Carrousel', 'main');
        $newsBlock1 = $this->generateBlockWysiwyg('News1', '<div class=news><h1>First News</h1><h2>Sub Title</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. earum eligendi explicabo hic illum ipsa</p><a href="#"></a></div>', 'main');
        $newsBlock2 = $this->generateBlockWysiwyg('News2', '<div class=news><h1>second News</h1><h2>Sub Title</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. earum eligendi explicabo hic illum ipsa</p><a href="#"></a></div>', 'main');
        $newsBlock3 = $this->generateBlockWysiwyg('News3', '<div class=news><h1>Third News</h1><h2>Sub Title</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. earum eligendi explicabo hic illum ipsa</p><a href="#"></a></div>', 'main');
        $newsBlock4 = $this->generateBlockWysiwyg('News4', '<div class="news right0"><h1>Fourth News</h1><h2>Sub Title</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. earum eligendi explicabo hic illum ipsa</p><a href="#"></a></div>', 'main');
        $newsBlock5 = $this->generateBlockWysiwyg('News5', '<div class=news><h1>Fifth News</h1><h2>Sub Title</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. earum eligendi explicabo hic illum ipsa</p><a href="#"></a></div>', 'main');
        $newsBlock6 = $this->generateBlockContentList('news', 'ul_news', 'title_news', 'newsurl', 'News 6', 'main');
        $clearMain = $this->generateClearBlock('main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 5),
                array('nodeId' => 0, 'blockId' => 6),
                array('nodeId' => 0, 'blockId' => 7),
                array('nodeId' => 0, 'blockId' => 8),
                array('nodeId' => 0, 'blockId' => 9),
                array('nodeId' => 0, 'blockId' => 10),
                array('nodeId' => 0, 'blockId' => 11),
                array('nodeId' => 0, 'blockId' => 12),
                array('nodeId' => 0, 'blockId' => 13),
            )
        );


        // Footer
        $footerBlock = $this->generateFooterBlock('Footer', 'footer');
        $clearFooter = $this->generateClearBlock('footer');

        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => 0, 'blockId' => 14),
                array('nodeId' => 0, 'blockId' => 15),
            )
        );

        // Generation of the home node
        $node = $this->generateNode(array(
            'nodeId' => NodeInterface::ROOT_NODE_ID,
            'parentId' => '-',
            'path' => '-',
            'name' => 'Home',
            'alias' => 'home'
        ));

        $node->addArea($headerArea);
        $node->addBlock($loginBlock);
        $node->addBlock($logoBlock);
        $node->addBlock($search);
        $node->addBlock($menuBlock);
        $node->addBlock($clearHeader);

        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($carrouselBlock);
        $node->addBlock($newsBlock1);
        $node->addBlock($newsBlock2);
        $node->addBlock($newsBlock3);
        $node->addBlock($newsBlock4);
        $node->addBlock($newsBlock5);
        $node->addBlock($newsBlock6);
        $node->addBlock($clearMain);

        $node->addArea($footerArea);
        $node->addBlock($footerBlock);
        $node->addBlock($clearFooter);
        return $node;
    }

    
    /**
     * @return Node
     */
    protected function generateEspaceBDDF()
    {
        $descBlock = $this->generateBlockWysiwyg('BDDF', '<h1>Page Espace BDDF</h1>', 'main');
        $loginBlock = $this->generateBlockLogin('Login', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1)
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'espace_BDDF',
            'parentId' => NodeInterface::ROOT_NODE_ID,
            'path' => 'espace-bddf',
            'name' => 'Espace BDDF',
            'alias' => 'espace-bddf',
        ));
        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($loginBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateEspaceCardif()
    {
        $descBlock = $this->generateBlockWysiwyg('Cardif', '<h1>Page Espace Cardif</h1>', 'main');
        $loginBlock = $this->generateBlockLogin('Login', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1)
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'espace_Cardif',
            'parentId' => NodeInterface::ROOT_NODE_ID,
            'path' => 'espace-cardif',
            'name' => 'Espace Cardif',
            'alias' => 'espace-cardif',
        ));
        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($loginBlock);

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
        ));
        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($loginBlock);

        return $node;
    }

    /**
     * @return Node
     */
    protected function generateCardifActualiteNews6()
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
            'nodeId' => 'newsurl',
            'parentId' => 'espace_Cardif',
            'path' => 'news-url',
            'name' => 'Actualité',
            'alias' => 'newsurl'
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
        ));
        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($loginBlock);

        return $node;
    }

}
