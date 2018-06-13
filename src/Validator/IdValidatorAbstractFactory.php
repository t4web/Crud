<?php

namespace T4web\Crud\Validator;

use Zend\ServiceManager\Factory\AbstractFactoryInterface;
use Interop\Container\ContainerInterface;

class IdValidatorAbstractFactory implements AbstractFactoryInterface
{
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $explodedName = explode('-', $requestedName);
        return count($explodedName) == 4
            && $explodedName[1] == 'crud'
            && $explodedName[2] == 'id'
            && $explodedName[3] == 'validator';
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $explodedName = explode('-', $requestedName);

        $entity = $explodedName[0];

        $entityExistValidator = $container->get("$entity-crud-entityexist-validator");

        return new IdValidator($entityExistValidator);
    }
}
