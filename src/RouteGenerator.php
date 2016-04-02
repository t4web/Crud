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

            $entity = $options['entity'];

            if (!empty($options['backend']['actions'])) {

                $actions = $options['backend']['actions'];
                $namespace = isset($options['backend']['namespace']) ? $options['backend']['namespace'] : '/admin';

                if (in_array('new', $actions)) {
                    $routeOptions = [
                        'controller' => 'sebaks-zend-mvc-controller',
                        'allowedMethods' => ['GET'],
                    ];
                    if (!empty($options['backend']['options']['new'])) {
                        $routeOptions = array_merge($routeOptions, $options['backend']['options']['new']);
                    }

                    $route = Literal::factory([
                        'route' => $namespace . '/' . $entity . '/new',
                        'defaults' => $routeOptions
                    ]);

                    $this->router->addRoute('admin-' . $entity . '-new', $route);
                }
                if (in_array('create', $actions)) {
                    $routeOptions = [
                        'controller' => 'sebaks-zend-mvc-controller',
                        'allowedMethods' => ['POST'],
                        'service' => $entity . '-crud-create-service',
                        'redirectTo' => 'admin-' . $entity . '-list',
                    ];
                    if (!empty($options['backend']['options']['create'])) {
                        $routeOptions = array_merge($routeOptions, $options['backend']['options']['create']);
                    }

                    $route = Literal::factory([
                        'route' => $namespace . '/' . $entity . '/create',
                        'defaults' => $routeOptions
                    ]);

                    $this->router->addRoute('admin-' . $entity . '-create', $route);
                }
                if (in_array('read', $actions)) {
                    $routeOptions = [
                        'controller' => 'sebaks-zend-mvc-controller',
                        'allowedMethods' => ['GET'],
                        'routeCriteria' => 'id',
                        'criteriaValidator' => $entity . '-crud-id-validator',
                        'service' => $entity . '-crud-read-service',
                    ];
                    if (!empty($options['backend']['options']['read'])) {
                        $routeOptions = array_merge($routeOptions, $options['backend']['options']['read']);
                    }

                    $route = Segment::factory([
                        'route' => $namespace . '/' . $entity . '/read/:id',
                        'defaults' => $routeOptions
                    ]);

                    $this->router->addRoute('admin-' . $entity . '-read', $route);
                }
                if (in_array('update', $actions)) {
                    $routeOptions = [
                        'controller' => 'sebaks-zend-mvc-controller',
                        'allowedMethods' => ['POST'],
                        'routeCriteria' => 'id',
                        'criteriaValidator' => $entity . '-crud-id-validator',
                        'service' => $entity . '-crud-update-service',
                        'redirectTo' => 'admin-' . $entity . '-list',
                    ];
                    if (!empty($options['backend']['options']['update'])) {
                        $routeOptions = array_merge($routeOptions, $options['backend']['options']['update']);
                    }

                    $route = Segment::factory([
                        'route' => $namespace . '/' . $entity . '/update/:id',
                        'defaults' => $routeOptions
                    ]);

                    $this->router->addRoute('admin-' . $entity . '-update', $route);
                }
                if (in_array('delete', $actions)) {
                    $routeOptions = [
                        'controller' => 'sebaks-zend-mvc-controller',
                        'allowedMethods' => ['GET'],
                        'routeCriteria' => 'id',
                        'criteriaValidator' => $entity . '-crud-id-validator',
                        'service' => $entity . '-crud-delete-service',
                        'redirectTo' => 'admin-' . $entity . '-list',
                    ];
                    if (!empty($options['backend']['options']['delete'])) {
                        $routeOptions = array_merge($routeOptions, $options['backend']['options']['delete']);
                    }

                    $route = Segment::factory([
                        'route' => $namespace . '/' . $entity . '/delete/:id',
                        'defaults' => $routeOptions
                    ]);

                    $this->router->addRoute('admin-' . $entity . '-delete', $route);
                }
                if (in_array('delete-confirm', $actions)) {
                    $routeOptions = [
                        'controller' => 'sebaks-zend-mvc-controller',
                        'allowedMethods' => ['GET'],
                        'routeCriteria' => 'id',
                        'criteriaValidator' => $entity . '-crud-id-validator',
                    ];
                    if (!empty($options['backend']['options']['delete-confirm'])) {
                        $routeOptions = array_merge($routeOptions, $options['backend']['options']['delete-confirm']);
                    }

                    $route = Segment::factory([
                        'route' => $namespace . '/' . $entity . '/delete/:id/confirm',
                        'defaults' => $routeOptions
                    ]);

                    $this->router->addRoute('admin-' . $entity . '-delete-confirm', $route);
                }
                if (in_array('list', $actions)) {
                    $routeOptions = [
                        'controller' => 'sebaks-zend-mvc-controller',
                        'allowedMethods' => ['GET'],
                        'service' => $entity . '-crud-list-service',
                    ];
                    if (!empty($options['backend']['options']['list'])) {
                        $routeOptions = array_merge($routeOptions, $options['backend']['options']['list']);
                    }

                    $route = Segment::factory([
                        'route' => $namespace . '/' . $entity . '/list',
                        'defaults' => $routeOptions
                    ]);

                    $this->router->addRoute('admin-' . $entity . '-list', $route);
                }
            }
        }
    }
}
