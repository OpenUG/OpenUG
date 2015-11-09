<?php

namespace App\Test;

use App\Action\PageAction;
use App\Action\SimpleAction;
use App\Model\RepositoryManagerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Application;

class SiteTest extends \PHPUnit_Framework_TestCase
{
    use ContainerAwareTrait;

    public function testAllPagesGive200()
    {
        $container = $this->getContainer();
        $config = $container->get('config');
        $repositoryManager = $container->get(RepositoryManagerInterface::class);
        $application = $container->get(Application::class);

        foreach ($config['routes'] as $routeDescriptor) {
            if (!isset($routeDescriptor['type']) || 'repository' !== $routeDescriptor['type']) {
                continue;
            }

            $repository = $repositoryManager->getRepository($routeDescriptor['name']);
            $middleware = $container->get($routeDescriptor['middleware']);

            foreach ($repository->getAll() as $id => $entity) {
                $actionResponse = $middleware((new ServerRequest)->withAttribute('id', $id), new Response);
                $this->assertEquals(200, $actionResponse->getStatusCode());
            }
        }
    }
}
