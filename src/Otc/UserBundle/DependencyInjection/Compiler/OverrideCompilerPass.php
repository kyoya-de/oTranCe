<?php

namespace Otc\UserBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class OverrideCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('fos_user.registration.form.type');
        $definition->setClass('Otc\UserBundle\Form\Type\RegistrationFormType');

        $definition = $container->getDefinition('fos_user.profile.form.type');
        $definition->setClass('Otc\UserBundle\Form\Type\ProfileFormType');
    }
}
