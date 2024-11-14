<?php

declare(strict_types=1);

namespace LaminasTest\Mvc\Controller\TestAsset;

use interop\container\containerinterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;

class UnlocatableControllerLoaderAbstractFactory implements AbstractFactoryInterface
{
    /** @inheritDoc */
    public function canCreate(containerinterface $container, $requestedName)
    {
        return false;
    }

    /** @inheritDoc */
    public function __invoke(containerinterface $container, $requestedName, ?array $options = null)
    {
    }
}
