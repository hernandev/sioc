<?php

require __DIR__.'/vendor/autoload.php';

$container = \Sioc\Container::getInstance();

$container->register('user', \Demo\User::class);

$user = $container->make('user');

var_dump($user);