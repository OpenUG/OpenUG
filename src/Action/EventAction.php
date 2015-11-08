<?php

namespace App\Action;

use App\Model\Manager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class EventAction
{
    private $templateRenderer;

    /**
     * @var RepositoryManagerInterface
     */
    private $manager;

    public function __construct(TemplateRendererInterface $templateRenderer, RepositoryManagerInterface $manager)
    {
        $this->templateRenderer = $templateRenderer;
        $this->manager = $manager;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id');

        try {
            $event = $this->manager->getRepository('event')->get($id);
        } catch (\Exception $exception) {
            return $next($request, $response);
        }

        $template = $event->has('template') ? $event->get('template') : 'event';

        $html = $this->templateRenderer->render('app::' . $template, ['event' => $event]);

        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }
}
