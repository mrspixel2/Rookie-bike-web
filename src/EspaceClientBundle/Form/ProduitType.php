<?php

namespace EspaceClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
class ProduitType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom',TextType::class,array('attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')))
        ->add('description',TextType::class,array('attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')))
        ->add('prix',NumberType::class,array('attr' => array('class'=>'form-control','style' => 'margin-bottom:15px'))) 
        ->add('image',FileType::class,array('attr' => array('class'=>'btn','style' => 'margin-bottom:15px','value'=>'choisir image'),'data_class' => null))
        ->add('localisation',TextType::class,array('attr' => array('class'=>'form-control','style' => 'margin-bottom:15px')));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EspaceClientBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'espaceclientbundle_produit';
    }


}
