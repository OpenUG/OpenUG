<?php

namespace App\Action\Shared;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Handles requests for speaker pages.
 */
abstract class SimpleAction
{
    use ActionTrait;

    /**
     * Returns the repository name to be used by the action.
     *
     * @return string The repository name.
     */
    abstract protected function getRepositoryName();

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
        $id = $request->getAttribute('id');
        $repositoryName = $this->getRepositoryName();

        try {
            $entity = $this->repositoryManager->getRepository($repositoryName)->get($id);
        } catch (\Exception $exception) {
            return $next($request, $response);
        }

        $template = $entity->has('template') ? $entity->get('template') : $repositoryName;

        $html = $this->templateRenderer->render('app::' . $template, ['site' => $this->site, $repositoryName => $entity]);

        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }
}
