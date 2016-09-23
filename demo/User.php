<?php

namespace Demo;

/**
 * Class Foo.
 */
class User
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getName()
    {
        return $this->db->getName();
    }
}