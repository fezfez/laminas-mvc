<?php

declare(strict_types=1);

namespace Laminas\Mvc\Service;

use interop\container\containerinterface;
use Laminas\ServiceManager\AbstractPluginManager;
use Laminas\ServiceManager\Factory\FactoryInterface;

abstract class AbstractPluginManagerFactory implements FactoryInterface
{
    public const PLUGIN_MANAGER_CLASS = 'AbstractPluginManager';

    /**
     * Create and return a plugin manager.
     *
     * Classes that extend this should provide a valid class for
     * the PLUGIN_MANGER_CLASS constant.
     *
     * @param  string $name
     * @param  null|array $options
     * @return AbstractPluginManager
     */
    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        $options            = $options ?: [];
        $pluginManagerClass = static::PLUGIN_MANAGER_CLASS;
        return new $pluginManagerClass($container, $options);
    }
}
