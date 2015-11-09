<?php

namespace App\Test\Model;

use App\Model\RepositoryManagerFactory;
use App\Model\RepositoryManagerInterface;
use App\Test\ContainerAwareTrait;

class RepositoryManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
    use ContainerAwareTrait;

    public function testRepositoryManagerFactory()
    {
        $container = $this->getContainer();
        $repositoryManagerFactory = new RepositoryManagerFactory;
        $this->assertInstanceOf(RepositoryManagerInterface::class, $repositoryManagerFactory($container));
    }
}
