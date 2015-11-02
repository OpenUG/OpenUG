<?php

return [
    'dependencies' => [
        'factories' => [
            Zend\Expressive\Application::class => Zend\Expressive\Container\ApplicationFactory::class,
        ],
        'services' => [
            App\Model\Event\EventRepositoryInterface::class => new App\Model\Event\EventRepository('content/event/'),
            App\Model\Page\PageRepositoryInterface::class => new App\Model\Page\PageRepository('content/page/'),
            App\Model\Speaker\SpeakerRepositoryInterface::class => new App\Model\Speaker\SpeakerRepository('content/speaker/'),
            App\Model\Talk\TalkRepositoryInterface::class => new App\Model\Talk\TalkRepository('content/talk/'),
        ],
    ],
];
