<?php

namespace App\Books;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\Views\PhpRenderer;
use App\Lib\CurlRequestInterface;

class BooksController
{
    private $curlRequest;

    private $renderer;

    public function __construct(CurlRequestInterface $curlRequest, PhpRenderer $renderer) {
        $this->curlRequest = $curlRequest;
        $this->renderer = $renderer;
    }

    public function index(Request $request, Response $response)
    {
        // Get all the books to show
        $this->curlRequest->setURL('http://api.localtest.me/books');
        $this->curlRequest->setOption(CURLOPT_RETURNTRANSFER, true);
        $books = json_decode($this->curlRequest->execute());
        $this->curlRequest->close();

        // Get all the authors
        $this->curlRequest->setURL('http://api.localtest.me/authors');
        $this->curlRequest->setOption(CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode($this->curlRequest->execute());
        $this->curlRequest->close();

        // Loop through all books and add the author to each one for use in the listing template
        foreach ($books as $key => $book) {
            foreach ($authors as $author) {
                if ($book->author_id == $author->id) {
                    $books[$key]->author = $author;
                }
            }
        }


        return $this->renderer->render($response, 'list.php', [
            'books' => $books,
        ]);
    }

    public function create(Request $request, Response $response)
    {
        // Check if form data has been sent
        if ($request->isPost() &&  !empty($request->getParsedBody())) {
            // Make the api call to create the book
            $this->curlRequest->setURL('http://api.localtest.me/books/create');
            $this->curlRequest->setOption(CURLOPT_RETURNTRANSFER, true);
            $this->curlRequest->setOption(CURLOPT_POSTFIELDS, $request->getParsedBody());
            $this->curlRequest->execute();
            $this->curlRequest->close();

            // Redirect back to book listing
            return $response->withStatus(302)->withHeader('Location', '/books');
        }

        // Get all the authors
        $this->curlRequest->setURL('http://api.localtest.me/authors');
        $this->curlRequest->setOption(CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode($this->curlRequest->execute());
        $this->curlRequest->close();

        // Get all the currencies
        $this->curlRequest->setURL('http://api.localtest.me/currencies');
        $this->curlRequest->setOption(CURLOPT_RETURNTRANSFER, true);
        $currencies = json_decode($this->curlRequest->execute());
        $this->curlRequest->close();

        $data = [
            'authors' => $authors,
            'currencies' => $currencies,
        ];
        return $request->isGet()
            ? $this->renderer->render($response, 'create.php', $data)
            : $response->getBody()->write(json_encode($data));

    }

    public function update(Request $request, Response $response, array $params) {
        $ch = curl_init('http://api.localtest.me/books/view/' . $params['id']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $book = json_decode(curl_exec($ch));
        curl_close($ch);


        if (empty($book)) {
            //$this->flash->addMessage('Error', 'The book does not exits.');
            return $response->withStatus(302)->withHeader('Location', '/books');
        }

        if ($request->isPut() || $request->isPost()) {
            $ch = curl_init('http://api.localtest.me/books/update');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request->getParsedBody());
            curl_exec($ch);
            curl_close($ch);

            return $response->withStatus(302)->withHeader('Location', '/books');
        }


        // Get all the authors
        $ch = curl_init('http://api.localtest.me/authors');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $authors = json_decode(curl_exec($ch));
        curl_close($ch);

        $renderer = new PhpRenderer('../src/Books/templates/');
        $data = [
            'book' => $book,
            'authors' => $authors,
        ];

        return $request->isGet()
            ? $renderer->render($response, 'update.php', $data)
            : $response->getBody()->write(json_encode($data));
    }

    public function delete(Request $request, Response $response, array $params) {
        $ch = curl_init('http://api.localtest.me/books/view/' . $params['id']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $book = json_decode(curl_exec($ch));
        curl_close($ch);

        if (!empty($book)) {
            $this->flash->addMessage('Error', 'The book does not exits.');
            return $response->withStatus(302)->withHeader('Location', '/books');
        }

        $ch = curl_init('http://api.localtest.me/books/delete' . $params['id']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request->getParsedBody());
        curl_exec($ch);
        curl_close($ch);

        return $response->withStatus(302)->withHeader('Location', '/books');
    }

    private function dump($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;
    }
}
