<?php

namespace T4web\Crud;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Mvc\MvcEvent;

class RouteGeneratorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var MvcEvent $event */
        $event = $container->get('Application')->getMvcEvent();
        $router = $event->getRouter();
        $config = $container->get('config');
        $options = [];
        if (isset($config['t4web-crud']['route-generation']) && is_array($config['t4web-crud']['route-generation'])) {
            $options = $config['t4web-crud']['route-generation'];
        }

        return new RouteGenerator($router, $options);
    }
}
