<?php

namespace App\Test\Action;

use App\Action\EventAction;
use App\Action\EventActionFactory;
use App\Action\SpeakerAction;
use App\Action\SpeakerActionFactory;
use App\Model\Entity;
use App\Model\RepositoryManagerInterface;
use App\Test\Helper\Container;
use App\Test\Helper\Repository;
use App\Test\Helper\RepositoryManager;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Twig\TwigRenderer;

class SimpleActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider simpleActionProvider
     */
    public function testSimpleAction($repositoryName, $factoryClass, $expectedActionClass)
    {
        $entityId = 'foo';
        $templateResult = 'bar';

        $entity = new Entity($entityId, []);
        $site = new Entity('site', []);

        // Setup Mocks
        $repository = new Repository([$entityId => $entity]);
        $repositoryManager = new RepositoryManager([$repositoryName => $repository]);

        $templateRenderer = $this->getMockBuilder(TwigRenderer::class)->setMethods(['render'])->getMock();
        $templateRenderer
            ->expects($this->once())
            ->method('render')
            ->with('app::' . $repositoryName, ['site' => $site, $repositoryName => $entity])
            ->willReturn($templateResult);

        $container = new Container([
            RepositoryManagerInterface::class => $repositoryManager,
            TemplateRendererInterface::class => $templateRenderer,
            'site' => $site,
        ]);

        // Test Factory
        $factory = new $factoryClass;
        $action = $factory($container);
        $this->assertInstanceOf($expectedActionClass, $action);

        // Build action arguments
        $request = (new ServerRequest)->withAttribute('id', $entityId);
        $response = new Response;
        $next = function ($rq, $rs) { return $rs->withStatus(404); };

        // Test the response from the action
        $actionResponse = $action($request, $response, $next);
        $this->assertEquals(200, $actionResponse->getStatusCode());
        $this->assertEquals($templateResult, (string) $actionResponse->getBody());

        // Test not found
        $notFoundActionResponse = $action($request->withAttribute('id', null), $response, $next);
        $this->assertEquals(404, $notFoundActionResponse->getStatusCode());
    }

    public function simpleActionProvider()
    {
        return [
            ['event', EventActionFactory::class, EventAction::class],
            ['speaker', SpeakerActionFactory::class, SpeakerAction::class],
        ];
    }
}
