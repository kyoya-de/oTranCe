<?php

namespace Otc\UserBundle;

use Otc\UserBundle\DependencyInjection\Compiler\OverrideCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class OtcUserBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new OverrideCompilerPass());
    }

    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
