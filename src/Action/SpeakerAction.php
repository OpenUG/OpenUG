<?php

namespace App\Action;

use App\Model\Entity;
use App\Model\RepositoryManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class SpeakerAction
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
     * @var Entity
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
