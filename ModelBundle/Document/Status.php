<?php

namespace PHPOrchestra\ModelBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Status
 *
 * @MongoDB\Document(
 *   collection="status",
 *   repositoryClass="PHPOrchestra\ModelBundle\Repository\StatusRepository"
 * )
 */
class Status extends AbstractStatus
{
}