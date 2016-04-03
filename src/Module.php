<?php

namespace T4web\Crud;

use Zend\EventManager\EventManager;
use Zend\EventManager\EventInterface;
use Zend\Http\PhpEnvironment\Request;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(EventInterface $e)
    {
        /** @var EventManager $eventManager */
        $eventManager = $e->getApplication()->getEventManager();

        $eventManager->attach(MvcEvent::EVENT_ROUTE, function(EventInterface $e) {
            /** @var Request $request */
            $request = $e->getRequest();

            if (! $request instanceof Request) {
                return;
            }

            $serviceManager = $e->getApplication()->getServiceManager();
            $routeGenerator = $serviceManager->get(RouteGenerator::class);
            $routeGenerator->generate();
        }, 1000);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    'T4web\Crud' => __DIR__ . '/src',
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include dirname(__DIR__) . '/config/module.config.php';
    }
}

