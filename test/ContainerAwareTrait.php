<?php

namespace App\Test;

trait ContainerAwareTrait
{
    private $container = null;

    public function getContainer()
    {
        $this->container = $this->container ?: include __DIR__ . '/../config/container.php';
        return $this->container;
    }
}
