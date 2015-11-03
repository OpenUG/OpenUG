<?php

namespace App\Action;

use App\Model\Event\EventRepositoryInterface;
use App\Model\Speaker\SpeakerRepositoryInterface;
use App\Model\Talk\TalkRepositoryInterface;
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
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    /**
     * @var TalkRepositoryInterface
     */
    private $talkRepository;

    /**
     * @var SpeakerRepositoryInterface
     */
    private $speakerRepository;

    public function __construct(TemplateRendererInterface $templateRenderer, EventRepositoryInterface $eventRepository, TalkRepositoryInterface $talkRepository, SpeakerRepositoryInterface $speakerRepository)
    {
        $this->templateRenderer = $templateRenderer;
        $this->eventRepository = $eventRepository;
        $this->talkRepository = $talkRepository;
        $this->speakerRepository = $speakerRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        $id = $request->getAttribute('id');

        try {
            $result = $this->eventRepository->get($id);
        } catch (\Exception $exception) {
            return $next($request, $response);
        }

        $talks = [];

        foreach (array_map([$this->talkRepository, 'get'], $result->get('talks')) as $talk) {
            $talks[] = [
                'talk' => $talk,
                'speaker' => $this->speakerRepository->get($talk->get('speaker')),
            ];
        }

        $params = array_merge($result->getMetadata(), [
            'html' => $result->getHtml(),
            'talks' => $talks,
        ]);

        $template = isset($params['template']) ? $params['template'] : 'event';

        $html = $this->templateRenderer->render('app::' . $template, $params);

        $response->getBody()->write($html);
        return $response->withHeader('Content-Type', 'text/html');
    }
}
