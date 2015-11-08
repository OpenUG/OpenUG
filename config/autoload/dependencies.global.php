<?php

return [
    'dependencies' => [
        'factories' => [
            'site' => App\SiteFactory::class,
            App\Model\RepositoryManagerInterface::class => App\Model\RepositoryManagerFactory::class,
            Zend\Expressive\Application::class => Zend\Expressive\Container\ApplicationFactory::class,
        ],
    ],

    'repositories' => [
        'page' => [
            'path' => 'content/page/',
        ],
        'event' => [
            'class' => App\Model\Event\EventRepository::class,
            'path' => 'content/event/',
        ],
        'speaker' => [
            'path' => 'content/speaker/',
        ],
        'talk' => [
            'path' => 'content/talk/',
        ],
    ],

    'site-config-path' => 'content/site.yml',
];
