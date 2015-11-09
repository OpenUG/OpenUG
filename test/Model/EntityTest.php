<?php

namespace App\Test\Model;

use App\Model\Entity;

class EntityTest extends \PHPUnit_Framework_TestCase
{
    public function testEntity()
    {
        $id = 'foo';

        $properties = [
            'hello' => 'world',
            'lol' => ['test']
        ];

        $entity = new Entity($id, $properties);

        $this->assertEquals($id, $entity->getId());

        $this->assertFalse($entity->has('lalalalala'));

        try {
            $entity->get('lalalalala');
            $this->fail('should have thrown exception as property does not exist');
        } catch (\Exception $exception) { }

        foreach ($properties as $key => $value) {
            $this->assertTrue($entity->has($key));
            $this->assertEquals($value, $entity->get($key));
        }
    }
}
