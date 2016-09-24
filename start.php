<?php

require __DIR__.'/vendor/autoload.php';

// container instance
$container = \Sioc\Container::getInstance();

// create a database instance
$database = new \Demo\Database();

// register database as singleton that will resolve
// always the same instance
$container->register(\Demo\DatabaseInterface::class, new \Demo\Database());

// register \Demo\User on the alias user
$container->register('user', \Demo\User::class);

// Resolve the 'user'
$user = $container->make('user');

// show the user instance
var_dump($user);
// verify it's working
var_dump($user->getName());
// verify the database instance is the same on the singleton
var_dump($user->getDatabase() == $database);