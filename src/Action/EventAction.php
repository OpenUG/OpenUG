<?php

namespace App\Action;

/**
 * Handles requests for event pages.
 */
class EventAction extends Shared\SimpleAction
{
    protected function getRepositoryName()
    {
        return 'event';
    }
}
