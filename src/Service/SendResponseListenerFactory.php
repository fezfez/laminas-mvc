<?php

declare(strict_types=1);

namespace Laminas\Mvc\Service;

use interop\container\containerinterface;
use Laminas\Mvc\SendResponseListener;

class SendResponseListenerFactory
{
    /**
     * @return SendResponseListener
     */
    public function __invoke(containerinterface $container)
    {
        $listener = new SendResponseListener();
        $listener->setEventManager($container->get('EventManager'));
        return $listener;
    }
}
