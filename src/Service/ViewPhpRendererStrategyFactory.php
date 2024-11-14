<?php

declare(strict_types=1);

namespace Laminas\Mvc\Service;

use interop\container\containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Strategy\PhpRendererStrategy;

class ViewPhpRendererStrategyFactory implements FactoryInterface
{
    /**
     * @param  string $name
     * @param  null|array $options
     * @return PhpRendererStrategy
     */
    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        return new PhpRendererStrategy($container->get(PhpRenderer::class));
    }
}
