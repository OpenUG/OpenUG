<?php

namespace App\Action\Shared;

use App\Model\RepositoryManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Contains the shared code for creating the action classes.
 */
abstract class ActionFactory
{
    /**
     * @var string
     */
    private $actionClass;

    /**
     * Constructor.
     *
     * @param string $actionClass The action class to instantiate.
     */
    protected function __construct($actionClass)
    {
        $this->actionClass = $actionClass;
    }

    /**
     * Create the action.
     *
     * @param ContainerInterface $container The app container.
     *
     * @return callable The action class.
     */
    public function __invoke(ContainerInterface $container)
    {
        $templateRenderer = $container->get(TemplateRendererInterface::class);
        $repositoryManager = $container->get(RepositoryManagerInterface::class);
        $site = $container->get('site');

        return new $this->actionClass($templateRenderer, $repositoryManager, $site);
    }
}
