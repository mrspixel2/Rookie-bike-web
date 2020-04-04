<?php

namespace EspaceClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReclamationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('type', ChoiceType::class,array( 'choices'  => [
            'Continue indésrable' => 'Continue indésrable',
            'faux profil' => 'faux profil',
            'produit fake' => 'produit fake',
            
        ]))
        ->add('contenu',TextType::class,array('attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EspaceClientBundle\Entity\Reclamation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'espaceclientbundle_reclamation';
    }


}
