<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

/**
 *
 */
class TuneType extends AbstractType
{
    /**
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('tuneType')
            ->add('linkTheSession')
            ->add('isStared')
            ->add('tags')
            ->add('save', SubmitType::class)
            ->add('tuneFiles', CollectionType::class, array(
                'entry_type' => TuneFileType::class,
                'entry_options' => array('label' => false),
                'allow_add'    => true,
                'by_reference' => false,
                'allow_delete' => true,
            ));
    }

    /**
     *
     * @param \AppBundle\Form\OptionsResolver $resolver
     */
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => \AppBundle\Entity\Tune::class,
        ));
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return "tune";
    }
}
