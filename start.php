<?php

require __DIR__.'/vendor/autoload.php';

$container = \Sioc\Container::getInstance();

$database = new \Demo\Database();

$container->register(\Demo\DatabaseInterface::class, new \Demo\Database());

$container->register('user', \Demo\User::class);

/** @var \Demo\User $user */
$user = $container->make('user');

var_dump($user);
var_dump($user->getName());
var_dump($user->getDatabase() == $database);