<?php

/*
 * This file is part of Zenify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Zenify\ControllerAutowire\Config\Definition;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Zenify\ControllerAutowire\Contract\Config\ConfigurationResolverInterface;
use Zenify\ControllerAutowire\ZenifyControllerAutowireBundle;

final class ConfigurationResolver implements ConfigurationResolverInterface
{
    /**
     * @var string[]
     */
    private $resolvedConfiguration;

    /**
     * {@inheritdoc}
     */
    public function resolveFromContainerBuilder(ContainerBuilder $containerBuilder)
    {
        if (!$this->resolvedConfiguration) {
            $processor = new Processor();
            $configs = $containerBuilder->getExtensionConfig(ZenifyControllerAutowireBundle::ALIAS);
            $configs = $processor->processConfiguration(new Configuration(), $configs);

            $this->resolvedConfiguration = $containerBuilder->getParameterBag()->resolveValue($configs);
        }

        return $this->resolvedConfiguration;
    }
}
