<?php
namespace Bilan\Micro;

 use Bilan\Micro\Database\QueryBilder;
 use Bilan\Micro\Database\DbAdapter;
 use Zend\Diactoros\ServerRequestFactory;
 use Zend\Diactoros\Response;
 use FastRoute;
 use Philo\Blade\Blade;
 use Bilan\Micro\Database\Conection;
 use Bilan\Micro\Database\Migrate;
 use Bilan\Micro\Support\Traits\Singleton;
 use Bilan\Micro\Container\Container;
 use Bilan\Micro\Event\EventManager;
 use Bilan\Micro\Model\Model;
 use Bilan\Micro\Model\Mapper;

 class Micro extends Container
{
    use Singleton;

     /**
      * Выполнение кода объекта как функции\
      *
      * @param  string $key
      * @return Micro
      */
     public function __invoke($key = null){
         return $key === null ? $this : $this->get($key);
     }

    /**
    * Запись роутов в хранилище
    *
    * @return void
    */
     public function bootstrap()
    {
        $this->set('view' ,     $this->initView());
        $this->set('request',   $this->initRequest());
        $this->set('response',  $this->initRespons());
        $this->set('db',        $this->initConectionDB());
        $this->set('migrate',   $this->initMigrate());
        $this->set('queryBilder',$this->initQueryBilder());
        $this->set('em',        $this->initEventManager());
        $this->set('adapter',   $this->initAdapter());
        $this->set('model',     $this->initModel());
        $this->set('mapper',     $this->initMapper());
        $this->set('router ',   $this->initRouter());
    }

    /**
    * Запись роутов в хранилище 
    *
    * @return void
    */
    public function initView(){
        return function(){
            $views = __DIR__ . '/../../views';
            $cache = __DIR__ . '/../../cache';
            return $blade = new Blade($views, $cache);           
        };
    }
     
    /**
    * Инициализация роутов
    *
    * @return  object $dispatcher
    */
    public function initRouter()
    {   
        $dispatcher = \FastRoute\simpleDispatcher(require __DIR__.'/../routes.php');
        $httpMethod = $_SERVER['REQUEST_METHOD'];

        $uri = $_SERVER['REQUEST_URI'];
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
       switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                echo "404 Not Found";
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                echo "405 Method Not Allowed";
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                echo $handler($this);
                break;
        }
        return $dispatcher;
    }
    
    /**
    * Инициализация объекта request
    *
    * @return  object $dispatcher
    */
    public function initRequest()
    {   
       return $request = ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
        
    }

    /**
    * Инициализация объекта request
    *
    * @return  object $response
    */
    public function initRespons()
    {   
       return $response = new Response();        
    }

    /**
     * Инициализация подключения к базе данных
     *
     * @return  object $pdo
     */
    public function initConectionDB()
    {
        return function() {
            $pdo = new Conection();
            return $pdo;
        };
    }

    /**
     * Инициализация миграции
     *
     * @return  object $migrate
     */
    public function initMigrate()
    {
        return function(){
            $migrate = new Migrate();
            return $migrate;
        };

    }

    /**
     * Инициализация QueryBilder
     *
     * @return  object $queryBilder
     */
    public function initQueryBilder()
    {
        return function(){
            $queryBilder = new QueryBilder();
            return $queryBilder;
        };
    }

    /**
     * Инициализация EventManager
     *
     * @return  object $eventManager
     */
    public function initEventManager()
    {
        return function(){
            $eventManager = new EventManager();
            return $eventManager;
        };

    }

    /**
     * Инициализация DbAdapter
     *
     * @return  object $adapter
     */
    public function initAdapter()
    {
        return function(){
            $adapter = new DbAdapter();
            return $adapter;
        };
    }

    /**
     * Инициализация Model
     *
     * @return  object $model
     */
    public function initModel()
    {
        return function(){
            $model = new Model();
            return $model;
        };
    }

    /**
     * Инициализация Mapper
     *
     * @return  object $mapper
     */
    public function initMapper()
    {
        return function(){
            $mapper = Mapper::getInstance();
            return $mapper;
        };
    }



}   