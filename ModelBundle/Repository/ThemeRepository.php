<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use PHPOrchestra\ModelInterface\Repository\ThemeRepositoryInterface;

/**
 * Class ThemeRepository
 */
class ThemeRepository extends DocumentRepository implements ThemeRepositoryInterface
{

}
