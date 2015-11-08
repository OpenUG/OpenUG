<?php

namespace App\Model;

interface RepositoryInterface
{
    /**
     * Repository constructor.
     * 
     * @param Manager $manager   The repository manager.
     * @param string  $directory The directory containing the entities.
     */
    public function __construct(Manager $manager, $directory);

    public function get($id);

    public function getAll();
}
