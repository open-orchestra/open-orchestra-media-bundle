<?php

namespace PHPOrchestra\ModelBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

/**
 * Class FieldIndexRepository
 */
class FieldIndexRepository extends DocumentRepository
{
    /**
     * Get All field that will be a link
     *
     * @return array
     */
    public function findAllLink()
    {
        $fields = $this->findBy(array('isLink' => true));
        $completeFields = array();

        foreach ($fields as $field) {
            $completeFields[] = $field->getFieldName().'_'.$field->getFieldType();
        }

        return $completeFields;
    }
}
