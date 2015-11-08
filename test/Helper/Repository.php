<?php

namespace App\Test\Helper;

use App\Model\RepositoryInterface;

class Repository implements RepositoryInterface
{
    private $entities;

    public function __construct(array $entities)
    {
        $this->entities = $entities;
    }


    public function get($id)
    {
        if (!isset($this->entities[$id])) {
            throw new Exception;
        }

        return $this->entities[$id];
    }

    public function getAll()
    {
        return $this->entities;
    }
}
