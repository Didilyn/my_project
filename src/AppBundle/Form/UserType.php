<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('roleList', 'choice', array(
                'choices'   => array(
                    'ROLE_ADMIN'   => 'ROLE_ADMIN',
                    'ROLE_CM'      => 'ROLE_USER'
                ),
                'property_path' => false,
                'multiple'  => false,
            ))*/
            ->add('email', 'email')
            ->add('username', 'text')
            ->add('password', 'repeated', array(
                    'type' => 'password',
                    'first_options'  => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'user';
    }
}