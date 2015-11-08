<?php

return [
    'dependencies' => [
        'factories' => [
            App\Model\RepositoryManagerInterface::class => App\Model\RepositoryManagerFactory::class,
            Zend\Expressive\Application::class => Zend\Expressive\Container\ApplicationFactory::class,
        ],
    ],

    'repositories' => [
        'event' => [
            'class' => App\Model\Event\EventRepository::class,
            'path' => 'content/event/',
        ],
        'page' => [
            'path' => 'content/page/',
        ],
        'speaker' => [
            'path' => 'content/speaker/',
        ],
        'talk' => [
            'path' => 'content/talk/',
        ],
    ],
];
