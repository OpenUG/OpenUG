<?php

namespace App\Model;

interface RepositoryManagerInterface
{
    /**
     * Retrieve a repository.
     *
     * @param string $name The name of the repository.
     *
     * @return RepositoryInterface
     *
     * @throws \Exception If the repository has not been registered
     */
    public function getRepository($name);
}
