<?php

declare(strict_types=1);

namespace LaminasTest\Mvc\Controller\TestAsset;

use interop\container\containerinterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;

class UnlocatableControllerLoaderAbstractFactory implements AbstractFactoryInterface
{
    public function canCreate(containerinterface $container, $name)
    {
        return false;
    }

    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
    }
}
