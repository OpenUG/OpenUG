<?php

namespace App\Model;

interface RepositoryInterface
{
    public function get($id);

    public function getAll();
}
