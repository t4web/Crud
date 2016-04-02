<?php

return [
    'service_manager' => [
        'abstract_factories' => [
            T4web\Crud\ListServiceAbstractFactory::class,
            T4web\Crud\ReadServiceAbstractFactory::class,
            T4web\Crud\CreateServiceAbstractFactory::class,
            T4web\Crud\UpdateServiceAbstractFactory::class,
            T4web\Crud\DeleteServiceAbstractFactory::class,
            T4web\Crud\EntityExistValidatorAbstractFactory::class,
            T4web\Crud\IdValidatorAbstractFactory::class,
        ],
        'factories' => [
            T4web\Crud\RouteGenerator::class =>  T4web\Crud\RouteGeneratorFactory::class
        ],
        'invokables' => [

        ],
    ],
];
