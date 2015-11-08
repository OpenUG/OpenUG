<?php

namespace App\Test\Helper;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

class Container implements ContainerInterface
{
    private $services;

    public function __construct(array $services)
    {
        $this->services = $services;
    }

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new ServiceNotFoundException;
        }

        return $this->services[$id];
    }

    public function has($id)
    {
        return isset($this->services[$id]);
    }
}
