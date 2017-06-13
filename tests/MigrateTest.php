<?php
namespace Bilan\Tests;

use PHPUnit\Framework\TestCase;
use  Bilan\Micro\Database\TestMigrate;

/**
 * Тестирование работы минраций
 */
class MigrateTest extends TestCase
{
    /**
     * Тестирование создания и удаление талиц.
     */
    public function testMigrate()
    {
        $testMigrate = new TestMigrate();
        $testMigrate->up();
        $conection = micro('db');
        $pdo = $conection->getConection();
        $stmt = $pdo->prepare('SHOW TABLES FROM '.$conection->getParams()['dbname'] .' LIKE "'.$testMigrate->getTable().'"');
        $stmt->execute();
        $result = $stmt->fetchAll();

        $this->assertTrue(isset($result[0]), $message = 'The table is not created');

        $testMigrate->down();
        $stmt = $pdo->prepare('SHOW TABLES FROM '.$conection->getParams()['dbname'] .' LIKE "'.$testMigrate->getTable().'"');
        $stmt->execute();
        $result = $stmt->fetchAll();

        $this->assertFalse(isset($result[0]), $message = 'The table is not removed');


    }
}