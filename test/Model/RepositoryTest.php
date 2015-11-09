<?php

namespace App\Test\Model;

use App\Model\Entity;
use App\Model\Repository;
use App\Test\Helper\Repository as HelperRepository;
use App\Test\Helper\RepositoryManager;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testRepository()
    {
        $foreignEntity = new Entity('foreign', ['foo' => 'bar']);
        $helperRepository = new HelperRepository(['foreign' => $foreignEntity]);
        $repositoryManager = new RepositoryManager(['helper' => $helperRepository]);

        $repository = new Repository($repositoryManager, __DIR__ . '/repo/');

        $test = $repository->get('test');

        $this->assertContains('<h1>Heading 1</h1>', $test->get('html'));
        $this->assertContains('<p>Paragraph</p>', $test->get('html'));

        $this->assertEquals('Hello, World!', $test->get('Title'));
        $this->assertEquals($foreignEntity->get('foo'), $test->get('Entity')->get('foo'));

        try {
            $test->get('lalalalala');
            $this->fail('should have thrown exception, id does not exist');
        } catch (\Exception $exception) { }
    }
}
