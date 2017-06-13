<?php
namespace Bilan\Micro\Database;

/**
 * Миграция для таблицы с пользователями
 */
class UserMigrate extends  Migrate
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $field = [
        '`id` int(11) NOT NULL AUTO_INCREMENT',
        '`name` varchar(30) NOT NULL',
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
