<?php
namespace Bilan\Micro\Model;

use Bilan\Micro\Interfaces\Model\Mapper as MapperInterface;
use Bilan\Micro\Interfaces\Model\Model;
use Bilan\Micro\Support\Traits\Singleton;

class Mapper implements MapperInterface
{
    use Singleton;

    /**
     * Модели для persist/flush
     *
     * @var Model[]
     */
    protected $models = [];

    /**
     * Получаем модель.
     *
     * @param Model|string $model
     * @param int|array $id если int - ищем по id, если array, ищем по where
     *
     * @return bool|Model|Model[]
     */
    public function find($model, $id)
    {
        if (!($model instanceof Model)) {
            $model = new $model;
        }
        $where = is_array($id) ? $id : ['id' => $id];
        $rows = micro('adapter')->select()->table($model->getTable())->columns(['*'])->where($where)->get()->fetchAll();
        if (!count($rows)) {
            return false;
        }
        if (!is_array($id)) {
            return $model->fill(current($rows));
        }
        $collection = [];
        $model = get_class($model);
        foreach ($rows as $row) {
            $collection[] = (new $model)->fill($row);
        }

        return $collection;
    }

    /**
     * Сохраняем модель.
     *
     * @param Model $model
     *
     * @return bool
     */
    public function save(Model $model)
    {
        if ($model->getAttributes()['id']) {
            micro('adapter')->update()->table($model->getTable())->set($model->getAttributes())->get();
            return true;
        }
        micro('adapter')->insert()->table($model->getTable())->set($model->getAttributes())->get();
        return true;
    }

    /**
     * Получаем все модели из таблицы.
     *
     * @param Model|string $model
     *
     * @return Model[]
     */
    public function all($model)
    {
        if (!($model instanceof Model)) {

            $model = new $model;
        }
        $rows = micro('adapter')->select()->table($model->getTable())->columns(['*'])->get()->fetchAll();

        $collection = [];
        foreach ($rows as $row) {
            $collection[] = (new $model)->fill($row);
        }
        return $collection;
    }

    /**
     * Добавляем модель для транзакции.
     *
     * @param Model $model
     *
     * @throws \InvalidArgumentException Model can not be null.
     *
     * @return void
     */
    public function persist(Model $model)
    {
        if (empty($model)) {
            throw new \InvalidArgumentException('Model can not be null.');
        }
        array_push($this->models, $model);
    }

    /**
     * Комитим данные в базу.
     *
     * @throws \Exception Ошибка при открытии транзакции PDO.
     * @throws \Exception Ошибка при коммите запросов транзакции.
     *
     * @return bool
     */
    public function flush()
    {
        $dbAdapter = micro('adapter');
        // Открываем транзакцию.
        if (!$dbAdapter->beginTransaction()) {
            throw new \Exception('Ошибка при открытии транзакции PDO');
        }
        foreach ($this->models as $model) {
            micro('adapter')->insert()->table($model->getTable())->set($model->getAttributes())->get();
        }
        // Коммитим полученные запросы.
        if (!$dbAdapter->commit()) {
            $dbAdapter->rollBack();
            throw new Exception('Ошибка при коммите запросов транзакции');
        }
        $this->models = [];
        return true;
    }

    /**
     * Удаляем модель, предварительно проверяет наличие записи в БД
     *
     * @param Model|string $model
     * @param int|array $id если int - ищем по id, если array, ищем по where
     *
     * @throws \InvalidArgumentException Non entry.
     *
     * @return bool
     */
    public function delete($model, $id)
    {
        if (!($model instanceof Model)) {
            $model = new $model;
        }
        $where = is_array($id) ? $id : ['id' => $id];
        $data = $this->find($model, $id);
        if ($data) {
            $result = micro('adapter')->delete()->table($model->getTable())->where($where)->get();
            return true;
        } else {
            throw \InvalidArgumentException('Non entry');
        }
    }
}