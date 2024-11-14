<?php

declare(strict_types=1);

namespace Laminas\Mvc\Service;

use interop\container\containerinterface;
use Laminas\Mvc\View\Http\ViewManager as HttpViewManager;
use Laminas\ServiceManager\Factory\FactoryInterface;

class HttpViewManagerFactory implements FactoryInterface
{
    /**
     * Create and return a view manager for the HTTP environment
     *
     * @param  string $name
     * @param  null|array $options
     * @return HttpViewManager
     */
    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        return new HttpViewManager();
    }
}
