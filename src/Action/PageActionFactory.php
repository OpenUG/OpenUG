<?php

namespace App\Action;

use App\Model\Manager;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class PageActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $templateRenderer = $container->get(TemplateRendererInterface::class);
        $manager = $container->get(Manager::class);

        return new PageAction($templateRenderer, $manager);
    }
}
