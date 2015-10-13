<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $ages = array_combine(range(15, 90), range(15, 90));

        $builder
            ->add('username')
            ->add('fullname')
            ->add('age', 'choice', array('choices' => array($ages)))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'The password fields must match.',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Type the password again'),
            ))
            ->add('address', 'address')
            ->add('submit', 'submit')
        ;
    }

    public function getName()
    {
        return 'user';
    }
}
