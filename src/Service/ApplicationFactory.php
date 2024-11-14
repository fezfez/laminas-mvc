<?php

declare(strict_types=1);

namespace Laminas\Mvc\Service;

use interop\container\containerinterface;
use Laminas\Mvc\Application;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ApplicationFactory implements FactoryInterface
{
    /**
     * Create the Application service
     *
     * Creates a Laminas\Mvc\Application service, passing it the configuration
     * service and the service manager instance.
     *
     * @param  string $name
     * @param  null|array $options
     * @return Application
     */
    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        return new Application(
            $container,
            $container->get('EventManager'),
            $container->get('Request'),
            $container->get('Response')
        );
    }
}
