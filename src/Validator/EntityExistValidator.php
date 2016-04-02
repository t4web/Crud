<?php

namespace T4web\Crud\Validator;

use Zend\Validator\AbstractValidator;
use T4webDomainInterface\Infrastructure\RepositoryInterface;

class EntityExistValidator extends AbstractValidator
{
    const ENTITY_NOT_EXIST = 'entityNotExist';

    /**
     * @var RepositoryInterface
     */
    private $repository;

    protected $messageTemplates = [
        self::ENTITY_NOT_EXIST => "Entity with id '%value%' does not exists"
    ];

    /**
     * @param RepositoryInterface $repository
     */
    public function __construct(RepositoryInterface $repository, $options = null)
    {
        $this->repository = $repository;

        parent::__construct($options);
    }

    public function isValid($value)
    {
        $entity = $this->repository->findById($value);

        $this->setValue($value);

        if (!$entity) {
            $this->error(self::ENTITY_NOT_EXIST);
            return false;
        }

        return true;
    }
}
