<?php

declare(strict_types=1);

namespace Laminas\Mvc\Service;

use interop\container\containerinterface;
use Laminas\Mvc\View\Http\RouteNotFoundStrategy;
use Laminas\ServiceManager\Factory\FactoryInterface;

class HttpRouteNotFoundStrategyFactory implements FactoryInterface
{
    use HttpViewManagerConfigTrait;

    /**
     * @param  string $name
     * @param  null|array $options
     * @return RouteNotFoundStrategy
     */
    public function __invoke(containerinterface $container, $name, ?array $options = null)
    {
        $strategy = new RouteNotFoundStrategy();
        $config   = $this->getConfig($container);

        $this->injectDisplayExceptions($strategy, $config);
        $this->injectDisplayNotFoundReason($strategy, $config);
        $this->injectNotFoundTemplate($strategy, $config);

        return $strategy;
    }

    /**
     * Inject strategy with configured display_exceptions flag.
     */
    private function injectDisplayExceptions(RouteNotFoundStrategy $strategy, array $config)
    {
        $flag = $config['display_exceptions'] ?? false;
        $strategy->setDisplayExceptions($flag);
    }

    /**
     * Inject strategy with configured display_not_found_reason flag.
     */
    private function injectDisplayNotFoundReason(RouteNotFoundStrategy $strategy, array $config)
    {
        $flag = $config['display_not_found_reason'] ?? false;
        $strategy->setDisplayNotFoundReason($flag);
    }

    /**
     * Inject strategy with configured not_found_template.
     */
    private function injectNotFoundTemplate(RouteNotFoundStrategy $strategy, array $config)
    {
        $template = $config['not_found_template'] ?? '404';
        $strategy->setNotFoundTemplate($template);
    }
}
