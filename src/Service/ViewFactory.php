<?php

declare(strict_types=1);

namespace Laminas\Mvc\Service;

use interop\container\containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Strategy\PhpRendererStrategy;
use Laminas\View\View;

class ViewFactory implements FactoryInterface
{
    /**
     * @param  string $name
     * @param  null|array $options
     * @return View
     */
    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        $view   = new View();
        $events = $container->get('EventManager');

        $view->setEventManager($events);
        $container->get(PhpRendererStrategy::class)->attach($events);

        return $view;
    }
}
