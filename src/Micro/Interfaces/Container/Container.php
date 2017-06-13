<?php
namespace Bilan\Micro\Interfaces\Container;

/**
 * Описывает интерфейс контейнера, которая предоставляет методы для чтения своих записей.
 */
interface Container
{
    /**
     * Записывает объект в масив.
     *
     * @param string $key
     * @param string $binding
     *
     * @return void
     */
    public function set($key, $binding);

    /**
     * Возвращает объект из масива.
     *
     * @param string $key
     *
     * @throws InvalidArgumentException  В хранилище отсутствует запись с ключём: .$key.
     *
     * @return object
     */
    public function get($key);

    /**
     * Проверяет наличие значения в масиве.
     *
     * @param string $key
     *
     * @return bool
     */
    public function has($key);
}