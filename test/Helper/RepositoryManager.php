<?php

namespace App\Test\Helper;

use App\Model\RepositoryManagerInterface;

class RepositoryManager implements RepositoryManagerInterface
{
    private $repositories;

    public function __construct(array $repositories)
    {
        $this->repositories = $repositories;
    }

    public function getRepository($repository)
    {
        if (!isset($this->repositories[$repository])) {
            throw new \Exception;
        }

        return $this->repositories[$repository];
    }
}
