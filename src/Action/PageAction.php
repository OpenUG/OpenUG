<?php

namespace App\Action;

use App\Model\RepositoryManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class PageAction
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
        $id = $request->getAttribute('id', 'index');

        try {
            $page = $this->repositoryManager->getRepository('page')->get($id);
        } catch (\Exception $exception) {
            return $next($request, $response);
        }

        $eventRepository = $this->repositoryManager->getRepository('event');

        $params = [
            'page' => $page,
            'futureEvents' => $eventRepository->getFuture(),
            'pastEvents' => $eventRepository->getPast(),
        ];

        $template = $page->has('template') ? $page->get('template') : 'page';

        $html = $this->templateRenderer->render('app::' . $template, $params);

        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }
}
