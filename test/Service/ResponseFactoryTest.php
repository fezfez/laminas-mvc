<?php

declare(strict_types=1);

namespace LaminasTest\Mvc\Service;

use interop\container\containerinterface;
use Laminas\Http\Response as HttpResponse;
use Laminas\Mvc\Service\ResponseFactory;
use PHPUnit\Framework\TestCase;

class ResponseFactoryTest extends TestCase
{
    public function testFactoryCreatesHttpResponse()
    {
        $container = $this->createMock(containerinterface::class);
        $factory   = new ResponseFactory();
        $response  = $factory($container, 'Response');
        $this->assertInstanceOf(HttpResponse::class, $response);
    }
}
