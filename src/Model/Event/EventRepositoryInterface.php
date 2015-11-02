<?php

namespace App\Model\Event;

use App\Model\RepositoryInterface;

interface EventRepositoryInterface extends RepositoryInterface
{
    public function getNext();

    public function getPast();

    public function getFuture();
}
