<?php

namespace Zenify\ControllerAutowire\Tests\DependencyInjection\Compiler;

use PHPUnit_Framework_TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Zenify\ControllerAutowire\DependencyInjection\Compiler\RegisterControllersPass;
use Zenify\ControllerAutowire\DependencyInjection\ControllerClassMap;
use Zenify\ControllerAutowire\HttpKernel\Controller\ControllerFinder;
use Zenify\ControllerAutowire\Tests\DependencyInjection\Compiler\RegisterControllersPassSource\SomeController;
use Zenify\ControllerAutowire\ZenifyControllerAutowireBundle;

final class RegisterControllersPassTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var RegisterControllersPass
     */
    private $registerControllersPass;

    protected function setUp()
    {
        $controllerClassMap = new ControllerClassMap();
        $controllerClassMap->addController('somecontroller', 'SomeController');

        $controllerFinder = new ControllerFinder();
        $this->registerControllersPass = new RegisterControllersPass($controllerClassMap, $controllerFinder);
    }

    public function testProcess()
    {
        $containerBuilder = new ContainerBuilder();
        $this->assertCount(0, $containerBuilder->getDefinitions());

        $containerBuilder->prependExtensionConfig(ZenifyControllerAutowireBundle::ALIAS, [
            'controller_dirs' => [
                __DIR__.'/RegisterControllersPassSource',
            ],
        ]);
        $this->registerControllersPass->process($containerBuilder);

        $definitions = $containerBuilder->getDefinitions();
        $this->assertCount(1, $definitions);

        /** @var Definition $controllerDefinition */
        $controllerDefinition = array_pop($definitions);
        $this->assertInstanceOf(Definition::class, $controllerDefinition);

        $this->assertSame(SomeController::class, $controllerDefinition->getClass());
        $this->assertTrue($controllerDefinition->isAutowired());
    }
}
