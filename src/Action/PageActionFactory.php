<?php

namespace App\Action;

use App\Model\Page\PageRepositoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class PageActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $templateRenderer = $container->get(TemplateRendererInterface::class);
        $pageRepository = $container->get(PageRepositoryInterface::class);

        return new PageAction($templateRenderer, $pageRepository);
    }
}
