<?php
namespace Bilan\Tests;

use PHPUnit\Framework\TestCase;
use Bilan\Micro\Micro;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response;
use Bilan\Micro\Database\Conection;
use Bilan\Micro\Database\QueryBilder;
use Bilan\Micro\Database\DbAdapter;
use Philo\Blade\Blade;
use Bilan\Micro\Database\Migrate;
use Bilan\Micro\Event\EventManager;
use Bilan\Micro\Model\Model;
use Bilan\Micro\Model\Mapper;

/**
 * Тестирование работы Micro
 */
class MicroTest extends TestCase
{
    /**
     * Тестирование класса Micro
     * - наличие метода bootstrap();
     */
    public function testMicro()
    {
        $micro = Micro::getInstance();
        $micro->bootstrap();

        $this->assertInstanceOf(Response::class, micro('response'));
        $this->assertInstanceOf(ServerRequest::class, micro('request'));

        $this->assertInstanceOf(EventManager::class, micro('em'));
        $this->assertInstanceOf(Blade::class, micro('view'));
        $this->assertInstanceOf(DbAdapter::class, micro('adapter'));
        $this->assertInstanceOf(Mapper::class, micro('mapper'));
        $this->assertInstanceOf(Model::class, micro('model'));
        $this->assertInstanceOf(QueryBilder::class, micro('queryBilder'));
        $this->assertInstanceOf(Migrate::class, micro('migrate'));
        $this->assertInstanceOf(Conection::class, micro('db'));


    }
}