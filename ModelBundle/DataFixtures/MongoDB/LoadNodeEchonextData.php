<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\Area;
use PHPOrchestra\ModelBundle\Document\Block;
use PHPOrchestra\ModelBundle\Document\Node;

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
        $node->setTheme('themePresentation');
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
        return $this->generateBlock('login', $blockLabel, $nodeId, $areaId);
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
     * @return Node
     */
    protected function generateNodeHome()
    {
        $descBlock = $this->generateBlockWysiwyg('Home', '<h1>Bienvenue sur le site de demo Echonext.</h1>', 'main');
        $loginBlock = $this->generateBlockLogin('Login', 'main');

        $mainArea = $this->generateArea('Main', 'main',
            array(
                array('nodeId' => 0, 'blockId' => 0),
                array('nodeId' => 0, 'blockId' => 1)
            )
        );

        $node = $this->generateNode(array(
            'nodeId' => 'root',
            'parentId' => '-',
            'path' => '-',
            'name' => 'Home'
        ));
        $node->addArea($mainArea);
        $node->addBlock($descBlock);
        $node->addBlock($loginBlock);

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
            'parentId' => 'root',
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
            'parentId' => 'root',
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
            'parentId' => 'root',
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
            'parentId' => 'root',
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
