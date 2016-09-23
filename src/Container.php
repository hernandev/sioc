<?php

namespace Sioc;

/**
 * Class Container.
 */
class Container
{
    /**
     * @var Container Instance of Sioc container
     */
    protected static $instance;

    /**
     * @var array List of IoC Bindings, empty array for default
     */
    protected $bindings = [];

    /**
     * Container constructor.
     *
     * Constructor is protected so people can never
     * do "new Container()"
     */
    protected function __construct()
    {
        //
    }

    /**
     * @return Container Current Sioc container instance
     */
    public static function getInstance()
    {
        // if there is not a instance yet, create a new one
        if (null === self::$instance) {
            self::$instance = new self();
        }

        // return the new or already existing instance
        return self::$instance;
    }

    /**
     * Register a class or alias into the Container.
     *
     * @param $alias Interface/Class/Alias register
     * @param $implementation Current implementation
     */
    public function register($alias, $implementation)
    {
        $this->bindings[$alias] = $implementation;
    }

    /**
     * UnRegister a Interface/Class/Alias.
     *
     * @param $aliasOrClassName
     */
    public function unRegister($aliasOrClassName)
    {
        if (array_key_exists($aliasOrClassName, $this->bindings)) {
            unset($this->bindings[$aliasOrClassName]);
        }
    }

    /**
     * Resolves and created a new instance of a desired class.
     *
     * @param $alias
     * @return object
     */
    public function make($alias)
    {
        if (class_exists($alias)) {
            return $this->makeInstance($alias);
        }

        if (array_key_exists($alias, $this->bindings)) {
            $className = $this->bindings[$alias];

            return $this->makeInstance($className);
        }


        throw new \RuntimeException('Desired class not found!');
    }

    /**
     * Created a instance of a desired class.
     *
     * @param $className
     * @return object
     */
    protected function makeInstance($className)
    {
        $reflection = new \ReflectionClass($className);

        return $reflection->newInstance();
    }
}