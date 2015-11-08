<?php

namespace App\Model;

interface RepositoryInterface
{
    /**
     * Repository constructor.
     *
     * @param RepositoryManagerInterface $manager   The repository manager.
     * @param string                     $directory The directory containing the entities.
     */
    public function __construct(RepositoryManagerInterface $repositoryManager, $directory);

    public function get($id);

    public function getAll();
}
