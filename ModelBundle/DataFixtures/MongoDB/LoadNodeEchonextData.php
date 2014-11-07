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
        $node->setAlias('-');
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
    protected function generateBlockCarrousel($blockLabel, $areaId, $nodeId = 0)
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

    protected function generateFooterBlock($blockLabel, $areaId, $nodeId = 0)
    {
        $footerBlock = $this->generateBlock('footer', $blockLabel, $nodeId, $areaId);
        $footerBlock->setAttributes(array(
            'id' => 'idFooter',
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
        $carrouselBlock = $this->generateBlockCarrousel('Carrousel', 'main');
        $newsBlock1 = $this->generateBlockWysiwyg('News1', '<div class=news><h1>First News</h1><h2>Sub Title</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. earum eligendi explicabo hic illum ipsa</p><a href="#"></a></div>', 'main');
        $newsBlock2 = $this->generateBlockWysiwyg('News2', '<div class=news><h1>second News</h1><h2>Sub Title</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. earum eligendi explicabo hic illum ipsa</p><a href="#"></a></div>', 'main');
        $newsBlock3 = $this->generateBlockWysiwyg('News3', '<div class=news><h1>Third News</h1><h2>Sub Title</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. earum eligendi explicabo hic illum ipsa</p><a href="#"></a></div>', 'main');
        $newsBlock4 = $this->generateBlockWysiwyg('News4', '<div class="news right0"><h1>Fourth News</h1><h2>Sub Title</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. earum eligendi explicabo hic illum ipsa</p><a href="#"></a></div>', 'main');
        $newsBlock5 = $this->generateBlockWysiwyg('News5', '<div class=news><h1>Fifth News</h1><h2>Sub Title</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. earum eligendi explicabo hic illum ipsa</p><a href="#"></a></div>', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 4),
                array('nodeId' => 0, 'blockId' => 5),
                array('nodeId' => 0, 'blockId' => 6),
                array('nodeId' => 0, 'blockId' => 7),
                array('nodeId' => 0, 'blockId' => 8),
                array('nodeId' => 0, 'blockId' => 9),
                array('nodeId' => 0, 'blockId' => 10),
            )
        );


        // Footer
        $footerBlock = $this->generateFooterBlock('Footer', 'footer');
        $footerArea = $this->generateArea('Footer', 'footer',
            array(
                array('nodeId' => 0, 'blockId' => 11)
            )
        );

        // Generation of the home node
        $node = $this->generateNode(array(
            'nodeId' => NodeInterface::ROOT_NODE_ID,
            'parentId' => '-',
            'path' => '-',
            'name' => 'Home'
        ));

        $node->addArea($headerArea);
        $node->addBlock($loginBlock);
        $node->addBlock($logoBlock);
        $node->addBlock($search);
        $node->addBlock($menuBlock);

        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($carrouselBlock);
        $node->addBlock($newsBlock1);
        $node->addBlock($newsBlock2);
        $node->addBlock($newsBlock3);
        $node->addBlock($newsBlock4);
        $node->addBlock($newsBlock5);

        $node->addArea($footerArea);
        $node->addBlock($footerBlock);
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
            'name' => 'Espace BDDF'
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
            'name' => 'Espace Cardif'
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
            'name' => 'Espace Arval'
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
            'name' => 'Espace XXX'
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
            'name' => 'Bienvenu'
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
            'name' => 'Actualité'
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
            'name' => 'Mission'
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
            'name' => 'Remunerations'
        ));
        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($loginBlock);

        return $node;
    }

}
