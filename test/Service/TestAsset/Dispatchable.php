<?php

declare(strict_types=1);

namespace LaminasTest\Mvc\Service\TestAsset;

use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\Controller\AbstractActionController;

class Dispatchable extends AbstractActionController
{
    /**
     * Override, so we can test injection
     */
    public function getEventManager(): EventManagerInterface|null
    {
        return $this->events;
    }
}
