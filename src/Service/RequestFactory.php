<?php

declare(strict_types=1);

namespace Laminas\Mvc\Service;

use interop\container\containerinterface;
use Laminas\Http\PhpEnvironment\Request as HttpRequest;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RequestFactory implements FactoryInterface
{
    /**
     * Create and return a request instance.
     *
     * @param  string $name
     * @param  null|array $options
     * @return HttpRequest
     */
    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        return new HttpRequest();
    }
}
