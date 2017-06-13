<?php
namespace Bilan\Micro\Database;

use PDO;

/**
 * Подключение к БД
 */
class Conection
{
    /**
     * @var array
     */
    protected $connectionParams = [
        'host' => 'localhost',
        'port' => 3306,
        'charset' => 'utf8',
        'user' => 'root',
        'password' => '',
        'dbname' => 'users'
    ];
     /**
     * @var string
     */
    protected $pdo = '';

    /**
     * Параметраы для подключения к базе данных.
     */
    public function __construct()
    {
        $config = $this->getConfigDB();
        $this->setParams($config);

        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s',
            $this->connectionParams['host'],
            $this->connectionParams['dbname'],
            $this->connectionParams['charset']
        );
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $this->pdo = new PDO($dsn, $this->connectionParams['user'], $this->connectionParams['password'], $opt);
    }

    /**
     * Установление параметров для подключения.
     *
     * @param array $params
     *
     * @return void
     */
    public function setParams(Array $params)
    {
        foreach ($params as $param => $value) {
            $this->setParam($param, $value);
        }
    }

    /**
     * Установление параметров для подключения ключ=>значение.
     *
     * @param string $param
     * @param string $value
     *
     * @return void
     */
    public function setParam($param, $value)
    {
        $this->connectionParams[$param] = $value;
    }

    /**
     * Получение параметров для подключения.
     *
     * @return array $connectionParams
     */
    public function getParams()
    {
        return $this->connectionParams;
    }

    /**
     * Получение параметров для из файла config.php.
     *
     * @return array
     */
    public function getConfigDB()
    {
        return require __DIR__ . '/../../../database/config.php';
    }

    /**
     * Получение переменной $pdo.
     *
     * @return object $pdo
     */
    public function getConection()
    {
        return $this->pdo;
    }


}