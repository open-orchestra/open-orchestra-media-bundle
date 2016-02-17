<?php

namespace OpenOrchestra\MediaModelBundle\EventListener;

use OpenOrchestra\BackofficeBundle\Model\DocumentGroupRoleInterface;
use OpenOrchestra\BackofficeBundle\Model\GroupInterface;
use OpenOrchestra\Media\Model\FolderInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class AbstractMediaFolderGroupRoleListener
 */
class AbstractMediaFolderGroupRoleListener
{
    use ContainerAwareTrait;

    protected $mediaFolderGroupRoleClass;

    /**
     * @param string $mediaFolderGroupRoleClass
     */
    public function __construct($mediaFolderGroupRoleClass)
    {
        $this->mediaFolderGroupRoleClass = $mediaFolderGroupRoleClass;
    }

    /**
     * @return array
     */
    protected function getMediaFolderRoles()
    {
        $collector = $this->container->get('open_orchestra_backoffice.collector.backoffice_role');

        return $collector->getRolesByType('media|media_folder');
    }

    /**
     * @param FolderInterface $folder
     *
     * @return string
     */
    protected function getFolderAccessType(FolderInterface $folder)
    {
        $accessType = DocumentGroupRoleInterface::ACCESS_INHERIT;
        if (null === $folder->getParent()) {
            $accessType = DocumentGroupRoleInterface::ACCESS_GRANTED;
        }

        return $accessType;
    }

    /**
     * @param FolderInterface $folder
     * @param GroupInterface  $group
     * @param string          $role
     * @param string          $accessType
     *
     * @return DocumentGroupRoleInterface
     */
    protected function createMediaFolderGroupRole(FolderInterface $folder, GroupInterface $group, $role, $accessType)
    {
        /** @var $mediaFolderGroupRole DocumentGroupRoleInterface */
        $mediaFolderGroupRole = new $this->mediaFolderGroupRoleClass();
        $mediaFolderGroupRole->setType('folder');
        $mediaFolderGroupRole->setId($folder->getId());
        $mediaFolderGroupRole->setRole($role);
        $mediaFolderGroupRole->setAccessType($accessType);
        $isGranted = (DocumentGroupRoleInterface::ACCESS_DENIED === $accessType) ? false : true;
        if (DocumentGroupRoleInterface::ACCESS_INHERIT === $accessType) {
            $parentFolderRole = $group->getDocumentRoleByTypeAndIdAndRole('folder', $folder->getParent()->getId(), $role);
            if ($parentFolderRole instanceof DocumentGroupRoleInterface) {
                $isGranted = $parentFolderRole->isGranted();
            }
        }
        $mediaFolderGroupRole->setGranted($isGranted);

        return $mediaFolderGroupRole;
    }
}
