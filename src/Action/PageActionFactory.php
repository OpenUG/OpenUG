<?php

namespace App\Action;

/**
 * Factory class for creating the page handler.
 */
class PageActionFactory extends Shared\ActionFactory
{
    public function __construct()
    {
        parent::__construct(PageAction::class);
    }
}
