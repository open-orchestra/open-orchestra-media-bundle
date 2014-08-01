<?php

namespace PHPOrchestra\ModelBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PHPOrchestra\ModelBundle\Document\ListIndex;

/**
 * Class LoadListIndex
 */
class LoadListIndexData implements FixtureInterface
{
    /**
     * Load data fixture
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $list1 = $this->generateListIndex1();
        $manager->persist($list1);

        $list2 = $this->generateListIndex2();
        $manager->persist($list2);

        $list3 = $this->generateListIndex3();
        $manager->persist($list3);

        $list4 = $this->generateListIndex4();
        $manager->persist($list4);

        $list5 = $this->generateListIndex5();
        $manager->persist($list5);

        $manager->flush();
    }

    /**
     * @return ListIndex
     */
    protected function generateListIndex1()
    {
        $listIndex = new ListIndex();

        $listIndex->setNodeId('fixture_full');

        return $listIndex;
    }

    /**
     * @return ListIndex
     */
    protected function generateListIndex2()
    {
        $listIndex = new ListIndex();

        $listIndex->setNodeId('fixture_about_us');

        return $listIndex;
    }

    /**
     * @return ListIndex
     */
    protected function generateListIndex3()
    {
        $listIndex = new ListIndex();

        $listIndex->setNodeId('fixture_bd');

        return $listIndex;
    }

    /**
     * @return ListIndex
     */
    protected function generateListIndex4()
    {
        $listIndex = new ListIndex();

        $listIndex->setContentId('1');

        return $listIndex;
    }

    /**
     * @return ListIndex
     */
    protected function generateListIndex5()
    {
        $listIndex = new ListIndex();

        $listIndex->setContentId('3');

        return $listIndex;
    }
}
