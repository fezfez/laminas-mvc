<?php

declare(strict_types=1);

namespace LaminasTest\Mvc;

use Laminas\EventManager\EventManager;
use Laminas\Http\PhpEnvironment\Request;
use Laminas\Mvc\ModuleRouteListener;
use Laminas\Mvc\MvcEvent;
use Laminas\Mvc\RouteListener;
use Laminas\Router\Http\TreeRouteStack;
use Laminas\Router\RouteMatch;
use PHPUnit\Framework\TestCase;

class ModuleRouteListenerTest extends TestCase
{
    private Request $request;
    private EventManager $events;
    private TreeRouteStack $router;
    private RouteListener $routeListener;
    private ModuleRouteListener $moduleRouteListener;

    public function setUp(): void
    {
        $this->request             = new Request();
        $this->events              = new EventManager();
        $this->router              = new TreeRouteStack();
        $this->routeListener       = new RouteListener();
        $this->moduleRouteListener = new ModuleRouteListener();

        $this->routeListener->attach($this->events);
        $this->moduleRouteListener->attach($this->events, -1);
    }

    public function testRouteReturningModuleNamespaceInRouteMatchTriggersControllerRename(): void
    {
        $this->router->addRoute('foo', [
            'type'    => 'Literal',
            'options' => [
                'route'    => '/foo',
                'defaults' => [
                    ModuleRouteListener::MODULE_NAMESPACE => 'Foo',
                    'controller'                          => 'Index',
                ],
            ],
        ]);
        $this->request->setUri('/foo');
        $event = new MvcEvent();
        $event->setName('route');
        $event->setRouter($this->router);
        $event->setRequest($this->request);
        $this->events->triggerEvent($event);

        $matches = $event->getRouteMatch();
        $this->assertInstanceOf(RouteMatch::class, $matches);
        $this->assertEquals('Foo\Index', $matches->getParam('controller'));
        $this->assertEquals('Index', $matches->getParam(ModuleRouteListener::ORIGINAL_CONTROLLER));
    }

    public function testRouteNotReturningModuleNamespaceInRouteMatchLeavesControllerUntouched(): void
    {
        $this->router->addRoute('foo', [
            'type'    => 'Literal',
            'options' => [
                'route'    => '/foo',
                'defaults' => [
                    'controller' => 'Index',
                ],
            ],
        ]);
        $this->request->setUri('/foo');
        $event = new MvcEvent();
        $event->setName('route');
        $event->setRouter($this->router);
        $event->setRequest($this->request);
        $this->events->triggerEvent($event);

        $matches = $event->getRouteMatch();
        $this->assertInstanceOf(RouteMatch::class, $matches);
        $this->assertEquals('Index', $matches->getParam('controller'));
    }

    public function testMultipleRegistrationShouldNotResultInMultiplePrefixingOfControllerName(): void
    {
        $moduleListener = new ModuleRouteListener();
        $moduleListener->attach($this->events);

        $this->router->addRoute('foo', [
            'type'    => 'Literal',
            'options' => [
                'route'    => '/foo',
                'defaults' => [
                    ModuleRouteListener::MODULE_NAMESPACE => 'Foo',
                    'controller'                          => 'Index',
                ],
            ],
        ]);
        $this->request->setUri('/foo');
        $event = new MvcEvent();
        $event->setName('route');
        $event->setRouter($this->router);
        $event->setRequest($this->request);
        $this->events->triggerEvent($event);

        $matches = $event->getRouteMatch();
        $this->assertInstanceOf(RouteMatch::class, $matches);
        $this->assertEquals('Foo\Index', $matches->getParam('controller'));
        $this->assertEquals('Index', $matches->getParam(ModuleRouteListener::ORIGINAL_CONTROLLER));
    }

    public function testRouteMatchIsTransformedToProperControllerClassName(): void
    {
        $moduleListener = new ModuleRouteListener();
        $moduleListener->attach($this->events);

        $this->router->addRoute('foo', [
            'type'    => 'Literal',
            'options' => [
                'route'    => '/foo',
                'defaults' => [
                    ModuleRouteListener::MODULE_NAMESPACE => 'Foo',
                    'controller'                          => 'some-index',
                ],
            ],
        ]);

        $this->request->setUri('/foo');
        $event = new MvcEvent();
        $event->setName('route');
        $event->setRouter($this->router);
        $event->setRequest($this->request);
        $this->events->triggerEvent($event);

        $matches = $event->getRouteMatch();
        $this->assertInstanceOf(RouteMatch::class, $matches);
        $this->assertEquals('Foo\SomeIndex', $matches->getParam('controller'));
        $this->assertEquals('some-index', $matches->getParam(ModuleRouteListener::ORIGINAL_CONTROLLER));
    }
}
