<?php

namespace T4web\Crud\Validator;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IdValidatorAbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceManager, $name, $requestedName)
    {
        $explodedName = explode('-', $requestedName);
        return count($explodedName) == 4
            && $explodedName[1] == 'crud'
            && $explodedName[2] == 'id'
            && $explodedName[3] == 'validator';
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceManager, $name, $requestedName)
    {
        $explodedName = explode('-', $requestedName);

        $entity = $explodedName[0];

        $entityExistValidator = $serviceManager->get("$entity-crud-entityexist-validator");

        return new IdValidator($entityExistValidator);
    }
}
