<?php

namespace LaminasTest\Mvc\Service;

use ArrayObject;
use Interop\Container\ContainerInterface;
use Laminas\Mvc\Service\InjectTemplateListenerFactory;
use Laminas\Mvc\View\Http\InjectTemplateListener;
use Laminas\ServiceManager\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * Tests for {@see \Laminas\Mvc\Service\InjectTemplateListenerFactory}
 *
 * @covers \Laminas\Mvc\Service\InjectTemplateListenerFactory
 */
class InjectTemplateListenerFactoryTest extends TestCase
{
    public function testFactoryCanCreateInjectTemplateListener()
    {
        $this->buildInjectTemplateListenerWithConfig([]);
    }

    public function testFactoryCanSetControllerMap()
    {
        $listener = $this->buildInjectTemplateListenerWithConfig([
            'view_manager' => [
                'controller_map' => [
                    'SomeModule' => 'some/module',
                ],
            ],
        ]);

        $this->assertEquals('some/module', $listener->mapController("SomeModule"));
    }

    public function testFactoryCanSetControllerMapViaArrayAccessVM()
    {
        $listener = $this->buildInjectTemplateListenerWithConfig([
            'view_manager' => new ArrayObject([
                'controller_map' => [
                    // must be an array due to type hinting on setControllerMap()
                    'SomeModule' => 'some/module',
                ],
            ])
        ]);

        $this->assertEquals('some/module', $listener->mapController("SomeModule"));
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|InjectTemplateListener
     */
    private function buildInjectTemplateListenerWithConfig(mixed $config)
    {
        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);
        $serviceLocator->method('get')->willReturn($config);

        $factory  = new InjectTemplateListenerFactory();
        $listener = $factory($serviceLocator, 'InjectTemplateListener');

        $this->assertInstanceOf(InjectTemplateListener::class, $listener);

        return $listener;
    }
}
