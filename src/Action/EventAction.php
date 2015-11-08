<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EventAction
{
    use ActionTrait;

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
