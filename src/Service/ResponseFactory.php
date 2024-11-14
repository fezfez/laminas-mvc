<?php

declare(strict_types=1);

namespace Laminas\Mvc\Service;

use interop\container\containerinterface;
use Laminas\Http\PhpEnvironment\Response as HttpResponse;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ResponseFactory implements FactoryInterface
{
    /**
     * Create and return a response instance.
     *
     * @param  string $name
     * @param  null|array $options
     * @return HttpResponse
     */
    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        return new HttpResponse();
    }
}
