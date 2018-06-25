<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichFileType;

/**
 *
 */
class TuneFileType extends AbstractType
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
            ->add('tuneFileType')
            ->add('file', VichFileType::class, array(
                'required'      => true,
                'allow_delete'  => true, // not mandatory, default is true
                'download_link' => true, // not mandatory, default is true
            ))
        ;

    }
    /**
     *
     * @param \AppBundle\Form\OptionsResolver $resolver
     */
    public function configureOptions(\Symfony\Component\OptionsResolver\OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => \AppBundle\Entity\TuneFile::class,
        ));
    }

    public function getName()
    {
        return 'tuneFile';
    }
}
