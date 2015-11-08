<?php

namespace App\Model;

class Entity
{
    private $id;
    private $properties;

    public function __construct($id, array $properties)
    {
        $this->id = $id;
        $this->properties = $properties;
    }

    public function getId()
    {
        return $this->id;
    }

    public function has($property)
    {
        return isset($this->properties[$property]);
    }

    public function get($property)
    {
        if (!$this->has($property)) {
            throw new \Exception('Property does not exist: ' . $property);
        }

        return $this->properties[$property];
    }
}
