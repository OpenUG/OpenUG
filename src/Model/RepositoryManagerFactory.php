<?php

namespace App\Model;

use Interop\Container\ContainerInterface;

class RepositoryManagerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new RepositoryManager($container->get('config')['repositories']);
    }
}
