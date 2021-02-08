<?php

$container = $app->getContainer();

$container['database'] = function ($c) {
  return new \Api\Lib\Database();
};

$container['\Api\Books\BooksController'] = function ($c) {
    return new \Api\Books\BooksController($c->get('database'));
};

$container['\Api\Currencies\CurrenciesController'] = function ($c) {
    return new \Api\Currencies\CurrenciesController($c->get('database'));
};