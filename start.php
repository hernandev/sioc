<?php

require __DIR__.'/vendor/autoload.php';

$container = \Sioc\Container::getInstance();

$container->register('foo', \Demo\Foo::class);

$foo = $container->make('foo');

var_dump($foo);