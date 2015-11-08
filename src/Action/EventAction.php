<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Handles requests for event pages.
 */
class EventAction
{
    use ActionTrait;

    /**
     * Handle a request for an event page.
     *
     * @param  ServerRequestInterface $request  The request.
     * @param  ResponseInterface      $response The response.
     * @param  callable               $next     The next middleware in the chain.
     *
     * @return ResponseInterface $response The response.
     */
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
