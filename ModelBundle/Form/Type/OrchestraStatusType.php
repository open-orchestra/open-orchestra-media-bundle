<?php

namespace PHPOrchestra\ModelBundle\Form\Type;

use PHPOrchestra\ModelBundle\Form\DataTransformer\EmbedStatusToStatusTransformer;
use PHPOrchestra\ModelInterface\Form\Type\AbstractOrchestraStatusType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class OrchestraStatusType
 */
class OrchestraStatusType extends AbstractOrchestraStatusType
{
    protected $statusTransformer;
    protected $statusClass;

    /**
     * @param EmbedStatusToStatusTransformer $statusTransformer
     * @param string                         $statusClass
     */
    public function __construct(EmbedStatusToStatusTransformer $statusTransformer, $statusClass)
    {
        $this->statusTransformer = $statusTransformer;
        $this->statusClass = $statusClass;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->statusTransformer);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'class' => $this->statusClass,
                'property' => 'labels',
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
