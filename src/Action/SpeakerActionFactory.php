<?php

namespace App\Action;

/**
 * Factory class for creating the speaker page handler.
 */
class SpeakerActionFactory extends ActionFactory
{
    public function __construct()
    {
        parent::__construct(SpeakerAction::class);
    }
}
