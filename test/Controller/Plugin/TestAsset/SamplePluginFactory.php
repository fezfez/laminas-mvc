<?php

declare(strict_types=1);

namespace LaminasTest\Mvc\Controller\Plugin\TestAsset;

use interop\container\containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SamplePluginFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(containerinterface $container, $requestedName, ?array $options = null)
    {
        return new SamplePlugin();
    }
}
