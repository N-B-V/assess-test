<?php

// Web app frontend routes
$app->get('/books', '\App\Books\BooksController:index');
$app->map(['POST', 'GET'], '/books/create', '\App\Books\BooksController:create');
$app->map(['POST', 'PUT', 'GET'], '/books/update/{id}', '\App\Books\BooksController:update');
$app->map(['DELETE', 'PUT', 'PATCH'], '/books/delete/{id}', '\App\Books\BooksController:delete');
// We don't have a homepage for this web app so just head to the books listing on first load
$app->redirect('/', '/books');


