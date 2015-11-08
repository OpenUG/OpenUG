<?php

namespace App\Action;

use App\Model\Entity;
use App\Model\RepositoryManagerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

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

    public function __construct(TemplateRendererInterface $templateRenderer, RepositoryManagerInterface $repositoryManager, Entity $site)
    {
        $this->templateRenderer = $templateRenderer;
        $this->repositoryManager = $repositoryManager;
        $this->site = $site;
    }
}
