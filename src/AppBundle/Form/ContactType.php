<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sender', 'text', array('label' => 'contact.sender', 'required' => false))
            ->add('subject', 'text', array('label' => 'contact.subject', 'required' => false))
            ->add('message', 'textarea', array('label' => 'contact.message', 'required' => false))
            ->add('send', 'submit', array('label' => 'contact.submit'))
        ;
    }

    public function getName()
    {
        return 'contact';
    }
}
