<?php

namespace models\db;

abstract class Query extends Database
{
    protected $_data;

    /**
     * Create item with parameters
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->_data = $data;
    }

    /**
     * Find all element by conditions
     *
     * @param array $conditions
     * @return static[]
     */
    public static function findAll($conditions = [])
    {
        $sql = 'SELECT * FROM `' . static::tableName() . '`';

        if (!empty($conditions)) {
            $sql .= ' WHERE ';

            $whereConditions = [];
            $newConditions = [];
            foreach ($conditions as $item => $value) {
                $whereConditions[] = "{$item} = :{$item}";

                $newConditions[":{$item}"] = $value;
            }

            $sql .= implode(' AND ', $whereConditions);
            $conditions = $newConditions;
        }

        $data = static::getConnection()->exec($sql, $conditions);

        $models = [];
        foreach ($data as $number => $model) {
            $models[] = new static($model);
        }

        return $models;
    }

    /**
     * Return element by id
     *
     * @param integer $id
     * @return static
     */
    public static function findById($id)
    {
        $data = static::findAll(['id' => $id]);
        return array_shift($data);
    }

    public function __get($name)
    {
        return $this->_data[$name] ?: null;
    }

    public function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }

    abstract static function tableName();
}