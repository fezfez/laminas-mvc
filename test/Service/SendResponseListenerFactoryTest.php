<?php

namespace LaminasTest\Mvc\Service;

use Interop\Container\ContainerInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\SharedEventManagerInterface;
use Laminas\Mvc\ResponseSender\HttpResponseSender;
use Laminas\Mvc\ResponseSender\PhpEnvironmentResponseSender;
use Laminas\Mvc\ResponseSender\SendResponseEvent;
use Laminas\Mvc\ResponseSender\SimpleStreamResponseSender;
use Laminas\Mvc\SendResponseListener;
use Laminas\Mvc\Service\SendResponseListenerFactory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class SendResponseListenerFactoryTest extends TestCase
{
    public function testFactoryReturnsListenerWithEventManagerFromContainer()
    {
        $sharedEvents = $this->createMock(SharedEventManagerInterface::class);
        $events = $this->createMock(EventManagerInterface::class);
        $events->method('getSharedManager')->willReturn($sharedEvents);

        $events->expects($this->once())
            ->method('setIdentifiers')
            ->with([SendResponseListener::class, SendResponseListener::class]);

        $events->expects($this->exactly(3))
            ->method('attach')
            ->withConsecutive(
                [
                    SendResponseEvent::EVENT_SEND_RESPONSE,
                    $this->isInstanceOf(PhpEnvironmentResponseSender::class),
                    -1000,
                ],
                [
                    SendResponseEvent::EVENT_SEND_RESPONSE,
                    $this->isInstanceOf(SimpleStreamResponseSender::class),
                    -3000,
                ],
                [
                    SendResponseEvent::EVENT_SEND_RESPONSE,
                    $this->isInstanceOf(HttpResponseSender::class),
                    -4000,
                ],
            );

        $container = $this->createMock(ContainerInterface::class);
        $container->method('get')->with('EventManager')->willReturn($events);

        $factory = new SendResponseListenerFactory();
        $listener = $factory($container);
        $this->assertInstanceOf(SendResponseListener::class, $listener);
        $this->assertSame($events, $listener->getEventManager());
    }
}
