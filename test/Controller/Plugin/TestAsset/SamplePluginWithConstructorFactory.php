<?php

declare(strict_types=1);

namespace LaminasTest\Mvc\Controller\Plugin\TestAsset;

use interop\container\containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class SamplePluginWithConstructorFactory implements FactoryInterface
{
    protected $options;

    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        return new SamplePluginWithConstructor($options);
    }

    public function setCreationOptions(array $options)
    {
        $this->options = $options;
    }
}
