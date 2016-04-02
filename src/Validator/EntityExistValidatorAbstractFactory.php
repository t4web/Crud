<?php

namespace T4web\Crud\Validator;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EntityExistValidatorAbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceManager, $name, $requestedName)
    {
        $explodedName = explode('-', $requestedName);
        return count($explodedName) == 4
            && $explodedName[1] == 'crud'
            && $explodedName[2] == 'entityexist'
            && $explodedName[3] == 'validator';
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceManager, $name, $requestedName)
    {
        $explodedName = explode('-', $requestedName);

        $entity = ucfirst($explodedName[0]);

        $repository = $serviceManager->get("$entity\\Infrastructure\\Repository");

        return new EntityExistValidator($repository);
    }
}
