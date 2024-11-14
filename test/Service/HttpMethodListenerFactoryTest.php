<?php

namespace LaminasTest\Mvc\Service;

use Interop\Container\ContainerInterface;
use Laminas\Mvc\Service\HttpMethodListenerFactory;
use Laminas\ServiceManager\ServiceLocatorInterface;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @covers Laminas\Mvc\Service\HttpMethodListenerFactory
 */
class HttpMethodListenerFactoryTest extends TestCase
{
    public function testCreateWithDefaults()
    {
        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);
        $factory = new HttpMethodListenerFactory();
        $listener = $factory($serviceLocator, 'HttpMethodListener');
        $this->assertTrue($listener->isEnabled());
        $this->assertNotEmpty($listener->getAllowedMethods());
    }

    public function testCreateWithConfig()
    {
        $config = [
            'http_methods_listener' => [
                'enabled' => false,
                'allowed_methods' => ['FOO', 'BAR']
            ]
        ];

        $serviceLocator = $this->createMock(ServiceLocatorInterface::class);
        $serviceLocator->method('get')->with('config')->willReturn($config);

        $factory = new HttpMethodListenerFactory();
        $listener = $factory($serviceLocator, 'HttpMethodListener');

        $listenerConfig = $config['http_methods_listener'];

        $this->assertSame($listenerConfig['enabled'], $listener->isEnabled());
        $this->assertSame($listenerConfig['allowed_methods'], $listener->getAllowedMethods());
    }
}
