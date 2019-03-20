<?php

namespace models;

use models\db\Query;

/**
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $name
 */
class User extends Query
{
    public static function tableName()
    {
        return 'user';
    }
}