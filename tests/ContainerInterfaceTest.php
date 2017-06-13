<?php
namespace Bilan\Tests;

use Bilan\Micro\Interfaces\Container\Container as ContainerInterface;
use Bilan\Micro\Container\Container;
use PHPUnit\Framework\TestCase;

class ContainerInterfaceTet extends TestCase
{
    /**
    * Тестирование ContainerInterface
    */
    public function testContainerInterface()
    {
        $container = new Container;
        $options = [
            'someKey' => 'someValue',
        ];
        $container->set('options', $options);
        $container->set(ContainerInterface::class, function () {
            return new Container;
        });
        $this->assertEquals($container->get('options'), $options);
        $this->assertInstanceOf(ContainerInterface::class, $container->get(ContainerInterface::class));
    }
}