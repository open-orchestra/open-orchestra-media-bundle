<?php

namespace PHPOrchestra\ModelBundle\FunctionalTest\Repository;

use PHPOrchestra\ModelBundle\Repository\ContentRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class ContentRepositoryTest
 */
class ContentRepositoryTest extends KernelTestCase
{
    /**
     * @var ContentRepository
     */
    protected $repository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('php_orchestra_model.repository.content');
    }

    /**
     * @param string $keyword
     * @param int    $count
     *
     * @dataProvider provideKeywordAndCount
     */
    public function testFindByKeyword($keyword, $count)
    {
        $keywords = $this->repository->findByKeyword($keyword);

        $this->assertCount($count, $keywords);
    }

    public function provideKeywordAndCount()
    {
        return array(
            array('Lorem', 2),
            array('Sit', 3),
            array('Dolor', 0),
        );
    }
}
