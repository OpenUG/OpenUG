<?php

namespace App\Test\Model;

use App\Model\Entity;
use App\Model\LazyLoadEntity;
use App\Test\Helper\Repository;

class LazyLoadEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testLazyLoadEntity()
    {
        $entity = new Entity('hello', ['foo' => 'bar']);
        $repository = new Repository(['hello' => $entity]);
        $lazyLoadEntity = new LazyLoadEntity($repository, 'hello');

        $this->assertEquals('hello', $lazyLoadEntity->getId());
        $this->assertTrue($lazyLoadEntity->has('foo'));
        $this->assertEquals('bar', $lazyLoadEntity->get('foo'));
        $this->assertFalse($lazyLoadEntity->has('lalalalala'));
    }
}
