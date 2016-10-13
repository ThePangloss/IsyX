<?php
// src/ozyx/PlatformBundle/Form/UserType.php

namespace ozyx\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('user', TextType::class)
            ->add('user', EntityType::class, array(
                'class' => 'UserBundle:User',
                'multiple' => false,
                'expanded' => false
              ))

            ->add('email', EmailType::class)
            ->add('roles', TextType::class)            
            ->add('password', PasswordType::class)
            ->add('Envoyer', SubmitType::class)
            ;
    }

    public function getName()
    {
        return 'user';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
      $resolver->setDefaults(array(
        'data_class' => 'ozyx\UserBundle\Entity\User'
      ));
    }
     
    public function getBlockPrefix()
    {
      return 'ozyx_UserBundle_usertype';
    }
}