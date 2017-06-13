<?php
namespace Bilan\Micro\Interfaces\Event;

/**
 * Описывает интерфейс событий, их добавление и прослушивание.
 */
interface EventManager
{
    /**
     * Добавляем обработчик события.
     *
     * @param string   $event
     * @param callable $callback
     *
     * @return mixed
     */
    public function listen($event, $callback);

    /**
     * Вызываем все обработчики для указанного события.
     *
     * @param string $event
     * @param mixed  $payload
     *
     * @return bool
     */
    public function fire($event, $payload);
}