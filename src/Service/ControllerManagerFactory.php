<?php

namespace Laminas\Mvc\Service;

// phpcs:ignore
use Interop\Container\ContainerInterface;
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
     * @param  string $requestedName
     * @param  null|array $options
     * @return ControllerManager
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        if ($options) {
            return new ControllerManager($container, $options);
        }
        return new ControllerManager($container);
    }
}
