<?php

namespace App\Action;

/**
 * Handles requests for speaker pages.
 */
class SpeakerAction extends Shared\SimpleAction
{
    protected function getRepositoryName()
    {
        return 'speaker';
    }
}
