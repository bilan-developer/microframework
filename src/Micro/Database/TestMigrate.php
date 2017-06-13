<?php
namespace Bilan\Micro\Database;

/**
 * Тестовый клас для проверки функционала миграции
 */
class TestMigrate extends  Migrate
{
    /**
     * @var string
     */
    protected $table = 'test_migrate';

    /**
     * @var array
     */
    protected $field = [
        '`id` int(11) NOT NULL AUTO_INCREMENT',
        '`test_name` varchar(30) NOT NULL',
        '`test_surname` varchar(30) NOT NULL',
        'PRIMARY KEY (`id`)'
    ];

    /**
     * @var string
     */
    protected $engine = 'InnoDB';

    /**
     * @var string
     */
    protected $charset = 'utf8';

    /**
     * Получение названия таблицы
     *
     * @return string $table
     */
    public function getTable(){
        return $this->table;
    }
}
