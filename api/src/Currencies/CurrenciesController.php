<?php


namespace Api\Currencies;


use Api\Lib\Database;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CurrenciesController
{
    private $db;

    public function __construct(Database $database) {
        $this->db = $database;
    }

    public function index(Request $request, Response $response)
    {
        $currencies = $this->db->query('SELECT * FROM currencies')
            ->fetchAll();

        return $response->getBody()->write(json_encode($currencies));
    }
}