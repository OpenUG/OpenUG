<?php

namespace App\Action;

class PageActionFactory extends ActionFactory
{
    public function __construct()
    {
        parent::__construct(PageAction::class);
    }
}
