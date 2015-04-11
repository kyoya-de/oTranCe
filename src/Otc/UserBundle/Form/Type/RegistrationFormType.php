<?php

namespace Otc\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseFormType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends BaseFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('realName', null, array('label' => 'form.realName', 'translation_domain' => 'FOSUserBundle'));
    }
}
