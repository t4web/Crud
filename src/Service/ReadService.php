<?php


namespace T4web\Crud\Service;

use T4webDomainInterface\ServiceInterface;
use T4webDomainInterface\Infrastructure\RepositoryInterface;

class ReadService implements ServiceInterface
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle($criteria, $changes)
    {
        $criteria = $this->repository->createCriteria($criteria);

        return $this->repository->find($criteria);
    }
}
