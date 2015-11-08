<?php

namespace App\Test\Action;

use App\Action\EventAction;
use App\Action\EventActionFactory;
use App\Model\Entity;
use App\Model\RepositoryManagerInterface;
use App\Test\Helper\Container;
use App\Test\Helper\Repository;
use App\Test\Helper\RepositoryManager;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Plates\PlatesRenderer;

class EventActionTest extends \PHPUnit_Framework_TestCase
{
    public function testEventAction()
    {
        $eventId = 'foo';
        $templateResult = 'bar';

        $event = new Entity($eventId, []);

        $config = new \stdClass;
        $config->site = new Entity('site', []);

        // Setup Mocks
        $repository = new Repository([$eventId => $event]);
        $repositoryManager = new RepositoryManager(['event' => $repository]);

        $templateRenderer = $this->getMockBuilder(PlatesRenderer::class)->setMethods(['render'])->getMock();
        $templateRenderer
            ->expects($this->once())
            ->method('render')
            ->with('app::event', ['site' => $config->site, 'event' => $event])
            ->willReturn($templateResult);

        $container = new Container([
            RepositoryManagerInterface::class => $repositoryManager,
            TemplateRendererInterface::class => $templateRenderer,
            'config' => $config,
        ]);

        // Test Factory
        $eventActionFactory = new EventActionFactory;
        $eventAction = $eventActionFactory($container);
        $this->assertInstanceOf(EventAction::class, $eventAction);

        // Build action arguments
        $request = (new ServerRequest)->withAttribute('id', $eventId);
        $response = new Response;
        $next = function ($rq, $rs) { return $rs->withStatusCode(404); };

        // Test the response from the action
        $actionResponse = $eventAction($request, $response, $next);
        $this->assertEquals(200, $actionResponse->getStatusCode());
        $this->assertEquals($templateResult, (string) $actionResponse->getBody());
    }
}
