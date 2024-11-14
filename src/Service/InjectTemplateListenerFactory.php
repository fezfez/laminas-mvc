<?php

declare(strict_types=1);

namespace Laminas\Mvc\Service;

use interop\container\containerinterface;
use Laminas\Mvc\View\Http\InjectTemplateListener;
use Laminas\ServiceManager\Factory\FactoryInterface;

use function is_array;

class InjectTemplateListenerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     *
     * Create and return an InjectTemplateListener instance.
     *
     * @return InjectTemplateListener
     */
    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        $listener = new InjectTemplateListener();
        $config   = $container->get('config');

        if (
            isset($config['view_manager']['controller_map'])
            && (is_array($config['view_manager']['controller_map']))
        ) {
            $listener->setControllerMap($config['view_manager']['controller_map']);
        }

        return $listener;
    }
}
