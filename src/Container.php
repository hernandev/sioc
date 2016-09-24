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
        // if the alias or class name is registered
        if (array_key_exists($alias, $this->bindings)) {
            // get it
            $classOrObject = $this->bindings[$alias];

            // if is an object, just return it (singleton)
            if (is_object($classOrObject)) {
                return $classOrObject;
            }

            // if not object by a valid class, create and
            // return a new instance
            if (class_exists($classOrObject)) {
                return $this->makeInstance($classOrObject);
            }
        }

        // maybe it's not registered on the container
        // but still a valid class, in this case
        // create and return
        if (class_exists($alias)) {
            return $this->makeInstance($alias);
        }

        // otherwise just return null
        return null;
    }

    /**
     * Created a instance of a desired class.
     *
     * @param $className
     * @return object
     */
    protected function makeInstance($className)
    {
        // class reflection
        $reflection = new \ReflectionClass($className);
        // get the class constructor
        $constructor = $reflection->getConstructor();

        // if there is no constructor, just create and
        // return a new instance
        if (!$constructor) {
            return $reflection->newInstance();
        }

        // if there is parameters, get them!
        $constructorParameters = $constructor->getParameters();

        // resolved array of parameters
        $parametersToPass = [];

        // for each expected parameter,
        // go through the container and resolve it
        foreach($constructorParameters as $parameter) {
            // get the expected class
            $parameterClassName = $parameter->getClass()->name;

            // if there is a class
            if ($parameterClassName) {
                // ask the container to resolve it
                $parametersToPass[] = self::make($parameterClassName);
            }
        }

        // created and returns the new instance passing the
        // resolved parameters
        return $reflection->newInstanceArgs($parametersToPass ? $parametersToPass : []);
    }
}