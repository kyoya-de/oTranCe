<?php

namespace Otc\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\ProfileFormType as BaseFormType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileFormType extends BaseFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('realName', null, array('label' => 'form.realName', 'translation_domain' => 'FOSUserBundle'));
    }
}
