<?php

namespace App\Model;

class RepositoryManager implements RepositoryManagerInterface
{
    private $repositories;

    /**
     * Constructor.
     *
     * This must be passed an associative array of repository objects where the
     * key of each repository in the array is its name.
     *
     * @param array[] $repositoryDescriptor The repositories.
     */
    public function __construct(array $repositoryDescriptor)
    {
        $this->repositories = [];

        foreach ($repositoryDescriptor as $repository => $descriptor) {
            $class = isset($descriptor['class']) ? $descriptor['class'] : Repository::class;

            $this->repositories[$repository] = new $class($this, $descriptor['path']);
        }
    }

    /**
     * Retrieve a repository.
     *
     * @param string $name The name of the repository.
     *
     * @return RepositoryInterface
     *
     * @throws \Exception If the repository has not been registered
     */
    public function getRepository($name)
    {
        if (!isset($this->repositories[$name])) {
            throw new \Exception('Unregistered repository: ' . $name);
        }

        return $this->repositories[$name];
    }
}
