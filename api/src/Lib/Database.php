<?php


namespace Api\Lib;


class Database extends \PDO
{
    private const DB_NAME = 'assess_db';
    private const DB_HOST = 'database';
    private const DB_USERNAME = 'root';
    private const DB_PASSWORD = 'secret';

    protected $db;

    public function __construct()
    {
        parent::__construct(sprintf('mysql:host=%s;dbname=%s', self::DB_HOST, self::DB_NAME), self::DB_USERNAME, self::DB_PASSWORD);
        $this->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }
}