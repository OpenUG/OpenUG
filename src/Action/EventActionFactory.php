<?php

namespace App\Action;

use App\Model\Event\EventRepositoryInterface;
use App\Model\Speaker\SpeakerRepositoryInterface;
use App\Model\Talk\TalkRepositoryInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class EventActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $templateRenderer = $container->get(TemplateRendererInterface::class);
        $eventRepository = $container->get(EventRepositoryInterface::class);
        $talkRepository = $container->get(TalkRepositoryInterface::class);
        $speakerRepository = $container->get(SpeakerRepositoryInterface::class);

        return new EventAction($templateRenderer, $eventRepository, $talkRepository, $speakerRepository);
    }
}
