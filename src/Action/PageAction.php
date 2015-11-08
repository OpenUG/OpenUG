<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Handles requests for pages.
 */
class PageAction
{
    use ActionTrait;

    /**
     * Handle a request for a page.
     *
     * @param  ServerRequestInterface $request  The request.
     * @param  ResponseInterface      $response The response.
     * @param  callable               $next     The next middleware in the chain.
     *
     * @return ResponseInterface $response The response.
     */
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
            'site' => $this->site,
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
