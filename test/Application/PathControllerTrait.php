<?php

declare(strict_types=1);

namespace LaminasTest\Mvc\Application;

use Laminas\Http\PhpEnvironment\Request;
use Laminas\Http\PhpEnvironment\Response;
use Laminas\Mvc\Controller\ControllerManager;
use Laminas\Mvc\Service\ServiceListenerFactory;
use Laminas\Mvc\Service\ServiceManagerConfig;
use Laminas\Router\ConfigProvider;
use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\ServiceManager;
use Laminas\Stdlib\ArrayUtils;
use LaminasTest\Mvc\TestAsset\MockSendResponseListener;
use LaminasTest\Mvc\TestAsset\MockViewManager;
use LaminasTest\Mvc\TestAsset\PathController;
use LaminasTest\Mvc\TestAsset\StubBootstrapListener;
use ReflectionProperty;

trait PathControllerTrait
{
    public function prepareApplication()
    {
        $config = [
            'router' => [
                'routes' => [
                    'path' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/path',
                            'defaults' => [
                                'controller' => 'path',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $serviceListener = new ServiceListenerFactory();
        $r               = new ReflectionProperty($serviceListener, 'defaultServiceConfig');
        $r->setAccessible(true);
        $serviceConfig = $r->getValue($serviceListener);

        $serviceConfig = ArrayUtils::merge(
            $serviceConfig,
            (new ConfigProvider())->getDependencyConfig()
        );

        $serviceConfig = ArrayUtils::merge(
            $serviceConfig,
            [
                'aliases'    => [
                    'ControllerLoader' => ControllerManager::class,
                ],
                'factories'  => [
                    'ControllerManager' => static fn($services): ControllerManager =>
                        new ControllerManager($services, [
                            'factories' => [
                                'path' => static fn(): PathController => new PathController(),
                            ],
                        ]),
                    'Router'            => static fn($services) => $services->get('HttpRouter'),
                ],
                'invokables' => [
                    'Request'              => Request::class,
                    'Response'             => Response::class,
                    'ViewManager'          => MockViewManager::class,
                    'SendResponseListener' => MockSendResponseListener::class,
                    'BootstrapListener'    => StubBootstrapListener::class,
                ],
                'services'   => [
                    'config'            => $config,
                    'ApplicationConfig' => [
                        'modules'                 => [
                            'Laminas\Router',
                        ],
                        'module_listener_options' => [
                            'config_cache_enabled' => false,
                            'cache_dir'            => 'data/cache',
                            'module_paths'         => [],
                        ],
                    ],
                ],
            ]
        );
        $services      = new ServiceManager();
        (new ServiceManagerConfig($serviceConfig))->configureServiceManager($services);
        $application = $services->get('Application');

        $request = $services->get('Request');
        $request->setUri('http://example.local/path');

        $application->bootstrap();
        return $application;
    }
}
