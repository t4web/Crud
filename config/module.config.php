<?php

namespace T4web\Crud;

return [
    'service_manager' => [
        'abstract_factories' => [
            Service\ListServiceAbstractFactory::class,
            Service\ReadServiceAbstractFactory::class,
            Service\CreateServiceAbstractFactory::class,
            Service\UpdateServiceAbstractFactory::class,
            Service\DeleteServiceAbstractFactory::class,
            Validator\EntityExistValidatorAbstractFactory::class,
            Validator\IdValidatorAbstractFactory::class,
        ],
        'factories' => [
            RouteGenerator::class => RouteGeneratorFactory::class
        ],
    ],
];
