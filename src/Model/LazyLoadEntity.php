<?php

namespace App\Model;

class LazyLoadEntity
{
    private $repository;
    private $id;
    private $entity;

    public function __construct(RepositoryInterface $repository, $id)
    {
        $this->repository = $repository;
        $this->id = $id;
        $this->entity = null;
    }

    public function __call($name, array $arguments)
    {
        if (null === $this->entity) {
            $this->entity = $this->repository->get($this->id);
        }

        return call_user_func_array([$this->entity, $name], $arguments);
    }
}
