<?php

use Slim\Views\PhpRenderer;

$container = $app->getContainer();

$container['curlRequest'] = function ($c) {
    return new \App\Lib\CurlRequest();
};

$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    $renderers = [];

    foreach ($settings  as $controllerName => $setting) {
        $renderers[$controllerName] = new Slim\Views\PhpRenderer($setting['template_path']);
    }
    return $renderers;
};

$container['\App\Books\BooksController'] = function ($c) {
    return new \App\Books\BooksController($c->get('curlRequest'), $c->get('renderer')['BooksController']);
};