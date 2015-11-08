<?php

namespace App\Action;

use App\Model\RepositoryManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

abstract class ActionFactory
{
    /**
     * @var string
     */
    private $actionClass;

    protected function __construct($actionClass)
    {
        $this->actionClass = $actionClass;
    }

    /**
     * Create the action.
     *
     * @param ContainerInterface $container
     *
     * @return callable
     */
    public function __invoke(ContainerInterface $container)
    {
        $templateRenderer = $container->get(TemplateRendererInterface::class);
        $repositoryManager = $container->get(RepositoryManagerInterface::class);
        $site = $container->get('config')->site;

        return new $this->actionClass($templateRenderer, $repositoryManager, $site);
    }
}
