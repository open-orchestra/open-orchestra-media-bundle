<?php

namespace PHPOrchestra\MediaBundle\FunctionalTest\Repository;

use PHPOrchestra\MediaBundle\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class MediaRepositoryTest
 */
class MediaRepositoryTest extends KernelTestCase
{
    /**
     * @var MediaRepository
     */
    protected $repository;

    /**
     * Set up test
     */
    protected function setUp()
    {
        parent::setUp();

        static::bootKernel();
        $this->repository = static::$kernel->getContainer()->get('php_orchestra_media.repository.media');
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
            array('Sit', 0),
            array('Dolor', 1),
        );
    }
}
