<?php

namespace PHPOrchestra\ModelBundle\Form\Type;

use PHPOrchestra\ModelInterface\Form\Type\AbstractOrchestraRoleType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class OrchestraRoleType
 */
class OrchestraRoleType extends AbstractOrchestraRoleType
{
    protected $roleClass;

    /**
     * @param string $roleClass
     */
    public function __construct($roleClass)
    {
        $this->roleClass = $roleClass;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'class' => $this->roleClass,
            )
        );
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'document';
    }
}
