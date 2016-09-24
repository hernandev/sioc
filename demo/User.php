<?php

namespace Demo;

/**
 * Class Foo.
 */
class User
{
    protected $db;

    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
    }

    public function getName()
    {
        return $this->db->getName();
    }

    public function getDatabase()
    {
        return $this->db;
    }
}