<?php

declare(strict_types=1);

namespace LaminasTest\Mvc\Controller\Plugin\TestAsset;

use interop\container\containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SamplePluginFactory implements FactoryInterface
{
    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        return new SamplePlugin();
    }
}
