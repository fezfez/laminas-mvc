<?php

declare(strict_types=1);

namespace LaminasTest\Mvc\TestAsset;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;

class MockViewManager extends AbstractListenerAggregate
{
    /** @inheritDoc */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_BOOTSTRAP, [$this, 'onBootstrap'], 10000);
    }

    public function onBootstrap()
    {
    }
}
