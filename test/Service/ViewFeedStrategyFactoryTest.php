<?php

declare(strict_types=1);

namespace LaminasTest\Mvc\Service;

use interop\container\containerinterface;
use Laminas\Mvc\Service\ViewFeedStrategyFactory;
use Laminas\View\Renderer\FeedRenderer;
use Laminas\View\Strategy\FeedStrategy;
use PHPUnit\Framework\TestCase;

class ViewFeedStrategyFactoryTest extends TestCase
{
    private function createContainer()
    {
        $renderer  = $this->createMock(FeedRenderer::class);
        $container = $this->createMock(containerinterface::class);
        $container->method('get')->with('ViewFeedRenderer')->willReturn($renderer);
        return $container;
    }

    public function testReturnsFeedStrategy()
    {
        $factory = new ViewFeedStrategyFactory();
        $result  = $factory($this->createContainer(), 'ViewFeedStrategy');
        $this->assertInstanceOf(FeedStrategy::class, $result);
    }
}
