<?php

namespace App\Action;

use App\Model\Entity;
use App\Model\RepositoryManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class EventAction
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

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id');

        try {
            $event = $this->repositoryManager->getRepository('event')->get($id);
        } catch (\Exception $exception) {
            return $next($request, $response);
        }

        $template = $event->has('template') ? $event->get('template') : 'event';

        $html = $this->templateRenderer->render('app::' . $template, ['site' => $this->site, 'event' => $event]);

        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }
}
