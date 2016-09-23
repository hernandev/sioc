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
     * Container constructor.
     *
     * Constructor is protected so people can never
     * do "new Container()"
     */
    protected function __construct()
    {
        //
    }
}