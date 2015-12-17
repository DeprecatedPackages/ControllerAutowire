<?php

namespace Zenify\ControllerAutowire\Tests;

use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Zenify\ControllerAutowire\Tests\AliasingBundle\AliasingBundle;
use Zenify\ControllerAutowire\ZenifyControllerAutowireBundle;

final class AppKernelWithAlias extends Kernel
{
    /**
     * {@inheritdoc}
     */
    public function registerBundles()
    {
        return [
            new FrameworkBundle(),
            new ZenifyControllerAutowireBundle(),
            new AliasingBundle(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/Resources/config/config.yml');
    }
}
