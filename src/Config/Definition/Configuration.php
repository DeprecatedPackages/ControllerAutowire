<?php

/*
 * This file is part of Symplify
 * Copyright (c) 2015 Tomas Votruba (http://tomasvotruba.cz).
 */

namespace Symplify\ControllerAutowire\Config\Definition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symplify\ControllerAutowire\SymplifyControllerAutowireBundle;

final class Configuration implements ConfigurationInterface
{
    /**
     * @var string[]
     */
    private $defaultControllerDirs = ['%kernel.root_dir%', '%kernel.root_dir%/../src'];

    /**
     * @var string[]
     */
    private $defaultAutowireTypes = [
        'doctrine.orm.default_entity_manager' => 'Doctrine\ORM\EntityManagerInterface',
        'event_dispatcher' => 'Symfony\Component\EventDispatcher\EventDispatcherInterface',
    ];

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root(SymplifyControllerAutowireBundle::ALIAS);

        $rootNode->children()
            ->arrayNode('controller_dirs')
                ->defaultValue($this->defaultControllerDirs)
                ->prototype('scalar')
            ->end();

        $rootNode->children()
            ->arrayNode('autowire_types')
                ->defaultValue($this->defaultAutowireTypes)
                ->prototype('scalar')
            ->end();

        return $treeBuilder;
    }
}
