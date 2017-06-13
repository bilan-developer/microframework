<?php
namespace Bilan\Tests;

use PHPUnit\Framework\TestCase;
use Bilan\Micro\Database\TestMigrate;
use Bilan\Models\TestClass;

/**
 * Тестирование работы мапера
 */
class ModelTest extends TestCase
{
    /**
     * @var object TestMigrate
     */
    protected $testMigrate;

    /**
     * @var object Mapper
     */
    protected $mapper;

    /**
     * @var object User
     */
    protected $user;

    /**
     * Инициализация переменных.
     * Создание тестовой таблицы.
     * Занисение в таблицу тестовых данных
     */
    protected function setUp()
    {
        $this->mapper = micro('mapper');
        $this->testMigrate = new TestMigrate();
        $this->testMigrate->up();
        $this->user = new TestClass();
        $this->user->fill(['test_name' => 'testName', 'test_surname' => 'testSurname']);
        $this->user->save();
    }

    /**
     * Удаление тестовой таблицы.
     */
    protected function tearDown()
    {
        $this->testMigrate->down();
    }

    /**
     * Тестирование метода find() и save().
     * - Поиск по id
     */
    public function testMapperFind()
    {
        $this->user = $this->user->find(1);
        $this->AssertNotFalse($this->user, $message = 'Error when searching by id');
    }

    /**
     * Тестирование метода refresh().
     * - Запись данных
     * - Поиск по id
     * - Обновление данных
     */
    public function testMapperRefresh()
    {
        $this->user = $this->user->find(1);
        $this->user->__set('test_name', 'Name');
        $this->user->refresh();
        $this->assertEquals($this->user->__get('test_name'), 'testName', 'Error when updating data');
    }

    /**
     * Тестирование метода delete().
     * - Запись данных
     * - Поиск по id
     * - Удаление данных
     * - Поиск по id
     */
    public function testMapperDelete()
    {
        $this->user = $this->user->find(1);
        $this->user->delete();
        $this->user = $this->user->find(1);
        $this->assertFalse($this->user, 'Error when deleting data');
    }


}