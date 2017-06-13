<?php
namespace Bilan\Tests;

use PHPUnit\Framework\TestCase;
use Bilan\Micro\Micro;

/**
 * Тестирование работы EventManager
 */
class EventManagerTest extends TestCase
{
    /**
     * Тестирование работоспособности отслеживания событий().
     */
    public function testEventManager()
    {
        $micro = Micro::getInstance();
        $micro->bootstrap();

        $str = 'test';
        $em = $micro->get('em');
        $em->listen('test', function($payload){
            var_dump($payload);
            return true;
        });
        $this->assertEquals(true, $em->fire('test', $str));
        $this->assertEquals(false, $em->fire('noevent', $str));
    }
}