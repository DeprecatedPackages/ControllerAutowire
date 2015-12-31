<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\ControllerAutowire\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symplify\ControllerAutowire\Config\Definition\ConfigurationResolver;

final class DefaultAutowireTypesPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $containerBuilder)
    {
        $autowireTypes = $this->getAutowireTypes($containerBuilder);
        foreach ($autowireTypes as $serviceName => $type) {
            if (!$containerBuilder->has($serviceName)) {
                continue;
            }

            if ($containerBuilder->hasAlias($serviceName)) {
                $serviceName = $containerBuilder->getAlias($serviceName);
            }

            $containerBuilder->getDefinition($serviceName)
                ->setAutowiringTypes([$type]);
        }
    }

    /**
     * @return string[]
     */
    private function getAutowireTypes(ContainerBuilder $containerBuilder)
    {
        $config = (new ConfigurationResolver())->resolveFromContainerBuilder($containerBuilder);

        return $config['autowire_types'];
    }
}
