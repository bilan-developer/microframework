<?php
namespace Bilan\Micro\Model;

use Bilan\Micro\Interfaces\Model\Model as ModelInterface;

class Model implements ModelInterface
{
    /**
     * Название таблицы
     *
     * @var string
     */
    protected $table = null;

    /**
     * Свойства модели
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Получаем модель из бд.
     *
     * @param int|array $id
     *
     * @return bool|ModelInterface|ModelInterface[]
     */
    public function find($id)
    {
        return micro('mapper')->find($this, $id);
    }

    /**
     * Сохраняем модель, (insert or create), в случае успеха вернем true.
     *
     * @return bool
     */
    public function save()
    {

        micro('em')->fire($this->table . '.created', $this);
        return micro('mapper')->save($this);
    }

    /**
     * Обновляем модель.
     *
     * @return void
     */
    public function refresh()
    {
        $data = $this->find($this->getAttributes()['id']);
        $this->fill($data->attributes);
    }

    /**
     * Удаляем модель, в случае успеха вернем true.
     *
     * @return bool
     */
    public function delete()
    {
        micro('em')->fire($this->table . '.deleted', $this);
        return micro('mapper')->delete($this, $this->getAttributes()['id']);

    }

    /**
     * Заполняем модель данными.
     *
     * @param array $attributes
     *
     * @return ModelInterface
     */
    public function fill(array $attributes)
    {
        if (!count($attributes)) {
            throw \InvalidArgumentException('Model\'s attributes can not be empty array');
        }
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * Получаем все модели из таблицы.
     *
     * @return Model[]
     */
    public function all()
    {
        return micro('mapper')->all($this);
    }

    /**
     * Получаем все свойства модели.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Получаем название таблицы модели.
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Устанавливаем название таблицы модели.
     *
     * @param string $table
     *
     * @return void
     */
    public function setTable($table)
    {
        if (!$table) {
            throw \InvalidArgumentException('Table can not be null.');
        }
        $this->table = $table;
    }

    /**
     * Магический метод __get
     *
     * @param $name
     *
     * @return mixed|null
     */
    public function __get($name)
    {
        return array_key_exists($name, $this->attributes) ? $this->attributes[$name] : null;
    }

    /**
     * Получаем ключи атрибутов.
     *
     * @return array
     */
    public function getKey()
    {
        return array_keys($this->getAttributes());
    }

    /**
     * Магический метод __set
     *
     * @param $name
     * @param $value
     *
     * @return void
     */
    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}