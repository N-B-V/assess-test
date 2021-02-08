<?php

$app->get('/authors', '\Api\Authors\AuthorsController:index');

$app->get('/books', '\Api\Books\BooksController:index');
$app->map(['POST', 'PUT'],'/books/create', '\Api\Books\BooksController:create');
$app->get('/books/view/{id}', '\Api\Books\BooksController:view');
$app->map(['POST', 'PUT'],'/books/update', '\Api\Books\BooksController:update');
$app->map(['PATCH', 'PUT'],'/books/delete/{id}', '\Api\Books\BooksController:delete');
$app->get('/currencies', '\Api\Currencies\CurrenciesController:index');