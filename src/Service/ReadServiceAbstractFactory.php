<?php

namespace T4web\Crud\Service;

use Zend\ServiceManager\Factory\AbstractFactoryInterface;
use Interop\Container\ContainerInterface;

class ReadServiceAbstractFactory implements AbstractFactoryInterface
{
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $explodedName = explode('-', $requestedName);
        return count($explodedName) == 4
            && $explodedName[1] == 'crud'
            && $explodedName[2] == 'read'
            && $explodedName[3] == 'service';
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $explodedName = explode('-', $requestedName);

        $entity = ucfirst($explodedName[0]);

        $repository = $container->get("$entity\\Infrastructure\\Repository");

        return new ReadService($repository);
    }
}
