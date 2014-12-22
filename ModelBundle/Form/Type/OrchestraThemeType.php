<?php

namespace PHPOrchestra\ModelBundle\Form\Type;

use PHPOrchestra\ModelInterface\Form\Type\AbstractOrchestraThemeType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class OrchestraThemeType
 */
class OrchestraThemeType extends AbstractOrchestraThemeType
{
    protected $themeClass;

    /**
     * @param string $themeClass
     */
    public function __construct($themeClass)
    {
        $this->themeClass = $themeClass;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'class' => $this->themeClass,
                'property' => 'name',
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
