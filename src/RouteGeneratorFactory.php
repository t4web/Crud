<?php

namespace T4web\Crud;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\MvcEvent;

class RouteGeneratorFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceManager)
    {
        /** @var MvcEvent $event */
        $event = $serviceManager->get('Application')->getMvcEvent();
        $router = $event->getRouter();
        $config = $serviceManager->get('config');
        $options = [];
        if (isset($config['t4web-crud']['route-generation']) && is_array($config['t4web-crud']['route-generation'])) {
            $options = $config['t4web-crud']['route-generation'];
        }

        return new RouteGenerator($router, $options);
    }
}
