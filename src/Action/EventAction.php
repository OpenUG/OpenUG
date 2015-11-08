<?php

namespace App\Action;

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

    public function __construct(TemplateRendererInterface $templateRenderer, RepositoryManagerInterface $repositoryManager)
    {
        $this->templateRenderer = $templateRenderer;
        $this->repositoryManager = $repositoryManager;
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

        $html = $this->templateRenderer->render('app::' . $template, ['event' => $event]);

        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }
}
