<?php

namespace App\Action;

/**
 * Factory class for creating the event page handler.
 */
class EventActionFactory extends ActionFactory
{
    public function __construct()
    {
        parent::__construct(EventAction::class);
    }
}
