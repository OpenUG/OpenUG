<?php

namespace App\Action;

/**
 * Factory class for creating the event page handler.
 */
class EventActionFactory extends Shared\ActionFactory
{
    public function __construct()
    {
        parent::__construct(EventAction::class);
    }
}
