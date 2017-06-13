<?php
namespace Bilan\Tests;

use PHPUnit\Framework\TestCase;
use Bilan\Micro\Database\TestMigrate;
use Bilan\Models\TestClass;

/**
 * Тестирование работы мапера
 */
class MapperTest extends TestCase
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
     * Инициализация переменных.
     * Создание таблицы для тестирования.
     */
    protected function setUp()
    {
        $this->mapper = micro('mapper');
        $this->testMigrate = new TestMigrate();
        $this->testMigrate->up();
    }

    /**
     * Удаление таблицы для тестирования.
     */
    protected function tearDown()
    {
        $this->testMigrate->down();
    }

    /**
     * Тестирование метода save().
     * - Запись данных
     * - Обновление данных
     */
    public function testMapperSave()
    {
        // Запись данных
        $user = new TestClass();
        $user->fill(['test_name'=>'testName', 'test_surname'=>'testSurname']);
        $this->mapper->save($user);
        // Выборка данных
        $data = $this->mapper->all($user);
        $result = count($data);

        $this->assertEquals(1, $result, 'Error writing');

        $data = current($data);
        $data->__set('test_name', 'Name');
        // Обновление данных
        $this->mapper->save($data);
        $data = $this->mapper->all($data);
        $result = count($data);
        $this->assertEquals(1, $result, 'Error writing updated data');
        $data = current($data);
        $this->assertEquals('Name', $data->__get(test_name), 'Data is not updated');
    }

    /**
     * Тестирование метода find().
     * - Запись данных
     * - Поиск по id
     */
    public function testMapperFind(){
        $user = new TestClass();
        $user->fill(['test_name'=>'testName', 'test_surname'=>'testSurname']);
        $this->mapper->save($user);

        $data = $this->mapper->find(TestClass::class, 1);
        $this->assertEquals('testName', $data->__get(test_name), 'Data is not correct');
        $this->assertInstanceOf(TestClass::class, $data, 'Wrong type of data');
    }

    /**
     * Тестирование транзакции.
     * - Запись данных
     * - Выбрка данных
     */
    public function testMapperTransaction(){
        $user = [];
        for($i = 0; $i<10; $i++){
            $user[$i] = new TestClass();
            $user[$i]->fill(['test_name'=>'testName', 'test_surname'=>'testSurname']);
            $this->mapper->persist($user[$i]);
        }
        $this->mapper->flush();
        $data = $this->mapper->all(\Bilan\Models\TestClass::class);
        $this->assertEquals(10, count($data), 'Error transaction');
        $this->assertInstanceOf(TestClass::class, $data[0], 'Wrong type of data');
    }

    /**
     * Тестирование удаление записи.
     *  - Запись данных
     *  - Удаление данных
     * - Проверка на наличие данных в БД
     */
    public function testMapperDelete(){
        $user = new TestClass();
        $user->fill(['test_name'=>'testName', 'test_surname'=>'testSurname']);
        $this->mapper->save($user);

        $this->mapper->delete(\Bilan\Models\TestClass::class, 1);
        $data = $this->mapper->all(\Bilan\Models\TestClass::class);
        $this->assertEquals(0, count($data), 'Error removal');

    }
}