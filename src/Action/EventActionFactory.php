<?php

namespace App\Action;

class EventActionFactory extends ActionFactory
{
    public function __construct()
    {
        parent::__construct(EventAction::class);
    }
}
