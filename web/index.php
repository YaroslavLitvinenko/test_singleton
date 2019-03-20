<?php

include_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'autoload.php');
use models\User;

$user = User::findById(3);

var_dump($user->name);