<?php

namespace App\Action;

use App\Model\Page\PageRepositoryInterface;
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
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    public function __construct(TemplateRendererInterface $templateRenderer, PageRepositoryInterface $pageRepository)
    {
        $this->templateRenderer = $templateRenderer;
        $this->pageRepository = $pageRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id', 'index');

        try {
            $result = $this->pageRepository->get($id);
        } catch (\Exception $exception) {
            return $next($request, $response);
        }

        $params = $result->getMetadata();
        $params['html'] = $result->getHtml();

        $template = isset($params['template']) ? $params['template'] : 'page';

        $html = $this->templateRenderer->render('app::' . $template, $params);

        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }
}
