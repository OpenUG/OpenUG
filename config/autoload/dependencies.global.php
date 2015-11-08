<?php

return [
    'dependencies' => [
        'factories' => [
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

    'site' => new App\Model\Entity('site', Symfony\Component\Yaml\Yaml::parse('content/site.yml')),
];
