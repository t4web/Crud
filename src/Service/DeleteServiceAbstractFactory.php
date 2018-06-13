<?php

namespace T4web\Crud\Service;

use Zend\ServiceManager\Factory\AbstractFactoryInterface;
use Interop\Container\ContainerInterface;
use T4webDomain\Service\Deleter;

class DeleteServiceAbstractFactory implements AbstractFactoryInterface
{
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $explodedName = explode('-', $requestedName);
        return count($explodedName) == 4
            && $explodedName[1] == 'crud'
            && $explodedName[2] == 'delete'
            && $explodedName[3] == 'service';
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $explodedName = explode('-', $requestedName);

        $entity = ucfirst($explodedName[0]);

        return new Deleter(
            $container->get("$entity\\Infrastructure\\Repository"),
            $container->get("$entity\\EntityEventManager")
        );
    }
}
