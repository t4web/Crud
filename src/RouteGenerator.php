<?php

namespace T4web\Crud;

use Zend\Mvc\Router\Http\TreeRouteStack as Router;
use Zend\Mvc\Router\Http\Literal;
use Zend\Mvc\Router\Http\Segment;

class RouteGenerator
{
    /**
     * @var Router
     */
    private $router;

    /**
     * @var array
     */
    private $options;

    /**
     * @param Router $router
     * @param array $options
     */
    public function __construct(Router $router, array $options)
    {
        $this->router = $router;
        $this->options = $options;
    }

    public function generate()
    {
        if (empty($this->options)) {
            return;
        }

        foreach ($this->options as $options) {

            if (empty($options['backend']['actions'])) {
                continue;
            }

            $entity = $options['entity'];

            $actions = $options['backend']['actions'];
            $namespace = isset($options['backend']['namespace']) ? $options['backend']['namespace'] : '/admin';

            if (in_array('new', $actions)) {
                $routeName = 'admin-' . $entity . '-new';
                $route = $namespace . '/' . $entity . '/new';
                $routeOptions = [
                    'controller' => 'sebaks-zend-mvc-controller',
                    'allowedMethods' => ['GET'],
                ];
                $newOptions = [];
                if (!empty($options['backend']['options']['new'])) {
                    $newOptions = $options['backend']['options']['new'];
                }

                $this->addRoute($routeName, $route, $routeOptions, $newOptions);
            }

            if (in_array('create', $actions)) {
                $routeName = 'admin-' . $entity . '-create';
                $route = $namespace . '/' . $entity . '/create';
                $routeOptions = [
                    'controller' => 'sebaks-zend-mvc-controller',
                    'allowedMethods' => ['POST'],
                    'service' => $entity . '-crud-create-service',
                    'redirectTo' => 'admin-' . $entity . '-list',
                ];
                $createOptions = [];
                if (!empty($options['backend']['options']['create'])) {
                    $createOptions = $options['backend']['options']['create'];
                }

                $this->addRoute($routeName, $route, $routeOptions, $createOptions);
            }

            if (in_array('read', $actions)) {
                $routeName = 'admin-' . $entity . '-read';
                $route = $namespace . '/' . $entity . '/read/:id';

                if (!empty($options['backend']['options']['read']['routeCriteria'])) {
                    $route = $namespace . '/' . $entity . '/read/:' . $options['backend']['options']['read']['routeCriteria'];
                }
                $routeOptions = [
                    'controller' => 'sebaks-zend-mvc-controller',
                    'allowedMethods' => ['GET'],
                    'routeCriteria' => 'id',
                    'criteriaValidator' => $entity . '-crud-id-validator',
                    'service' => $entity . '-crud-read-service',
                ];
                $readOptions = [];
                if (!empty($options['backend']['options']['read'])) {
                    $readOptions = $options['backend']['options']['read'];
                }
                if (!empty($options['backend']['options']['read']['routeCriteria'])) {
                    $readOptions['routeCriteria'] = $options['backend']['options']['read']['routeCriteria'];
                }

                $this->addRoute($routeName, $route, $routeOptions, $readOptions);
            }

            if (in_array('update', $actions)) {
                $routeName = 'admin-' . $entity . '-update';
                $route = $namespace . '/' . $entity . '/update/:id';

                if (!empty($options['backend']['options']['update']['routeCriteria'])) {
                    $route = $namespace . '/' . $entity . '/update/:' . $options['backend']['options']['update']['routeCriteria'];
                }

                $routeOptions = [
                    'controller' => 'sebaks-zend-mvc-controller',
                    'allowedMethods' => ['POST'],
                    'routeCriteria' => 'id',
                    'criteriaValidator' => $entity . '-crud-id-validator',
                    'service' => $entity . '-crud-update-service',
                    'redirectTo' => 'admin-' . $entity . '-list',
                ];
                $updateOptions = [];
                if (!empty($options['backend']['options']['update'])) {
                    $updateOptions = $options['backend']['options']['update'];
                }

                $this->addRoute($routeName, $route, $routeOptions, $updateOptions);
            }
            
            if (in_array('delete', $actions)) {
                $routeName = 'admin-' . $entity . '-delete';
                $route = $namespace . '/' . $entity . '/delete/:id';

                if (!empty($options['backend']['options']['delete']['routeCriteria'])) {
                    $route = $namespace . '/' . $entity . '/delete/:' . $options['backend']['options']['delete']['routeCriteria'];
                }

                $routeOptions = [
                    'controller' => 'sebaks-zend-mvc-controller',
                    'allowedMethods' => ['GET'],
                    'routeCriteria' => 'id',
                    'criteriaValidator' => $entity . '-crud-id-validator',
                    'service' => $entity . '-crud-delete-service',
                    'redirectTo' => 'admin-' . $entity . '-list',
                ];
                $deleteOptions = [];
                if (!empty($options['backend']['options']['delete'])) {
                    $deleteOptions = $options['backend']['options']['delete'];
                }

                $this->addRoute($routeName, $route, $routeOptions, $deleteOptions);
            }

            if (in_array('list', $actions)) {
                $routeName = 'admin-' . $entity . '-list';
                $route = $namespace . '/' . $entity . '/list';
                $routeOptions = [
                    'controller' => 'sebaks-zend-mvc-controller',
                    'allowedMethods' => ['GET'],
                    'service' => $entity . '-crud-list-service',
                ];
                $listOptions = [];
                if (!empty($options['backend']['options']['list'])) {
                    $listOptions = $options['backend']['options']['list'];
                }

                $this->addRoute($routeName, $route, $routeOptions, $listOptions);
            }
        }
    }

    private function addRoute($routeName, $route, $routeOptions, $options)
    {
        if (isset($options['routeName'])) {
            $routeName = $options['routeName'];
            unset($options['routeName']);
        }
        if (isset($options['route'])) {
            $route = $options['route'];
            unset($options['route']);
        }

        $routeOptions = array_merge($routeOptions, $options);

        $routeSegment = Segment::factory([
            'route' => $route,
            'defaults' => $routeOptions
        ]);

        $this->router->addRoute($routeName, $routeSegment);
    }
}
