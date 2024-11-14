<?php

declare(strict_types=1);

namespace Laminas\Mvc\Service;

use interop\container\containerinterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\View\Strategy\FeedStrategy;

class ViewFeedStrategyFactory implements FactoryInterface
{
    /**
     * Create and return the Feed view strategy
     *
     * Retrieves the ViewFeedRenderer service from the service locator, and
     * injects it into the constructor for the feed strategy.
     *
     * It then attaches the strategy to the View service, at a priority of 100.
     *
     * @param  string $name
     * @param  null|array $options
     * @return FeedStrategy
     */
    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        return new FeedStrategy($container->get('ViewFeedRenderer'));
    }
}
