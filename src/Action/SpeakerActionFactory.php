<?php

namespace App\Action;

class SpeakerActionFactory extends ActionFactory
{
    public function __construct()
    {
        parent::__construct(SpeakerAction::class);
    }
}
