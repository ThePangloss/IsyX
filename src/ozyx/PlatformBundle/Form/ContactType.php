<?php
// src/ozyx/PlatformBundle/Form/ContactType.php

namespace ozyx\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('subject', TextType::class)
            ->add('body', TextareaType::class)
            ->add('Envoyer', SubmitType::class)
            ;
    }

    public function getName()
    {
        return 'contact';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'ozyx\PlatformBundle\Entity\Contact'
      ));
    }
     
    public function getBlockPrefix()
    {
      return 'ozyx_platformbundle_contacttype';
    }
}