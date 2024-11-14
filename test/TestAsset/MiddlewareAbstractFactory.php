<?php

declare(strict_types=1);

namespace LaminasTest\Mvc\TestAsset;

use interop\container\containerinterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;

use function class_exists;

class MiddlewareAbstractFactory implements AbstractFactoryInterface
{
    public $classmap = [
        'test' => Middleware::class,
    ];

    public function canCreate(containerinterface $container, $name)
    {
        if (! isset($this->classmap[$name])) {
            return false;
        }

        $classname = $this->classmap[$name];
        return class_exists($classname);
    }

    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        $classname = $this->classmap[$name];
        return new $classname();
    }
}
