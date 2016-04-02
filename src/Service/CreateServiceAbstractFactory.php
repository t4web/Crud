<?php

namespace T4web\Crud\Service;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use T4webDomain\Service\Creator;

class CreateServiceAbstractFactory implements AbstractFactoryInterface
{
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceManager, $name, $requestedName)
    {
        $explodedName = explode('-', $requestedName);
        return count($explodedName) == 4
            && $explodedName[1] == 'crud'
            && $explodedName[2] == 'create'
            && $explodedName[3] == 'service';
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceManager, $name, $requestedName)
    {
        $explodedName = explode('-', $requestedName);

        $entity = ucfirst($explodedName[0]);

        return new Creator(
            $serviceManager->get("$entity\\Infrastructure\\Repository"),
            $serviceManager->get("$entity\\EntityFactory"),
            $serviceManager->get("$entity\\EntityEventManager")
        );
    }
}
