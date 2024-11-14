<?php

declare(strict_types=1);

namespace Laminas\Mvc\Service;

use interop\container\containerinterface;
use Laminas\Mvc\Controller\ControllerManager;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ControllerManagerFactory implements FactoryInterface
{
    /**
     * Create the controller manager service
     *
     * Creates and returns an instance of ControllerManager. The
     * only controllers this manager will allow are those defined in the
     * application configuration's "controllers" array. If a controller is
     * matched, the scoped manager will attempt to load the controller.
     * Finally, it will attempt to inject the controller plugin manager
     * if the controller implements a setPluginManager() method.
     *
     * @param  string $name
     * @param  null|array $options
     * @return ControllerManager
     */
    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        if ($options) {
            return new ControllerManager($container, $options);
        }
        return new ControllerManager($container);
    }
}
