<?php

namespace T\Services;

use MongoDB\Client;
use T\Interfaces\DB as DBInterface;
use T\Traits\Service;

class Mongodb /*extends \Truecode\Filesystem\DB*/ implements DBInterface
{
    use Service;

    protected $db;

    public function __construct($uri, $databaseName)
    {
        $this->db = (new Client($uri))->$databaseName;
    }

    public function __get($name) {
        return $this->db->$name;
    }
}
