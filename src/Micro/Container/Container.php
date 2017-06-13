<?php
namespace Bilan\Micro\Container;

use Bilan\Micro\Interfaces\Container\Container as ContainerInterface;


class Container implements ContainerInterface
{
    
    /**
     * Хранилище.
     *
     * @var array
     */
    private $instances = [];

   /**
    * Записывает объект в масив.
    *
    * @param string $key
    * @param string $binding
    *
    * @return void
    */
    public function set($key,  $binding)
    {
        $this->instances[$key] = $binding;
    }

    /**
     * Возвращает объект из масива.
     *
     * @param string $key
     *
     * @throws InvalidArgumentException  В хранилище отсутствует запись с ключём: .$key.
     *
     * @return object
     */
    public function get($key)
    {
        if($this->has($key)){
            if(is_callable($this->instances[$key])){
                $this->set($key, $this->instances[$key]());
            }
            return $this->instances[$key];
        }
        throw new InvalidArgumentException('В хранилище отсутствует запись с ключём: '.$key);   
    }

    /**
     * Проверяет наличие значения в масиве.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key)
    {
        return isset($this->instances[$key]);
    }
    
}