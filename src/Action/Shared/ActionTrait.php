<?php

namespace App\Action\Shared;

use App\Model\Entity;
use App\Model\RepositoryManagerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * Contains the shared code for constructing an action.
 */
trait ActionTrait
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var RepositoryManagerInterface
     */
    private $repositoryManager;

    /**
     * @param Entity
     */
    private $site;

    /**
     * Constructor.
     *
     * @param TemplateRendererInterface  $templateRenderer  The template renderer.
     * @param RepositoryManagerInterface $repositoryManager The repository manager.
     * @param Entity                     $site              The site entity.
     */
    public function __construct(TemplateRendererInterface $templateRenderer, RepositoryManagerInterface $repositoryManager, Entity $site)
    {
        $this->templateRenderer = $templateRenderer;
        $this->repositoryManager = $repositoryManager;
        $this->site = $site;
    }
}
