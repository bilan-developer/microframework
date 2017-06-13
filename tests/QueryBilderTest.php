<?php
use PHPUnit\Framework\TestCase;
use Bilan\Micro\Database\QueryBilder;

/**
 * Тестирование работы QueryBilder
 */
class QueryBilderTest extends TestCase
{
    /**
     * @var QueryBilder
     */
    protected $queryBilder;

    /**
     * Инициализация QueryBuilder.
     */
    public function setUp()
    {
        $this->queryBilder = new QueryBilder();
    }

    /**
     * Тестирование запроса SELECT.
     */
    public function testSelect()
    {
        $query = $this->queryBilder
            ->select()
            ->table('user', 'u')
            ->columns(['*'])
            ->where(['u.name' => 'test'])
            ->orderBy('id ASC')
            ->limit(4)
            ->bild();
       $this->assertEquals('SELECT * FROM  `user` AS u WHERE u.name = :name ORDER BY id ASC  LIMIT 4 ', $query);
    }

    /**
     * Тестирование запроса INSERT.
     */
    public function testInsert()
    {
        $query = $this->queryBilder->insert()
            ->table('user')
            ->set(['name' => 'Test'])
            ->bild();

        $this->assertEquals('INSERT INTO  `user` SET name = :name', $query);
    }

    /**
     * Тестирование запроса UPDATE.
     */
    public function testUpdate()
    {
        $query = $this->queryBilder->update()
            ->table('user')
            ->set(['name' => 'Test'])
            ->where(['id' => '5'])
            ->bild();
        $this->assertEquals('UPDATE  `user` SET name = :name WHERE id = :id', $query);
    }

    /**
     * Тестирование запроса DELETE.
     */
    public function testDelete()
    {
        $query = $this->queryBilder->delete()
            ->table('user')
            ->where(['id' => '1'])
            ->limit(1)
            ->bild();

        $this->assertEquals('DELETE FROM  `user` WHERE id = :id LIMIT 1 ', $query);
    }
}