<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Handles requests for speaker pages.
 */
class SpeakerAction
{
    use ActionTrait;

    /**
     * Handle a request for a speaker page.
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
            $speaker = $this->repositoryManager->getRepository('speaker')->get($id);
        } catch (\Exception $exception) {
            return $next($request, $response);
        }

        $template = $speaker->has('template') ? $speaker->get('template') : 'speaker';

        $html = $this->templateRenderer->render('app::' . $template, ['site' => $this->site, 'speaker' => $speaker]);

        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }
}
