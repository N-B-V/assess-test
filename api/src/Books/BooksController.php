<?php

namespace Api\Books;

use Api\Lib\Database;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class BooksController
{
    private $db;

    public function __construct(Database $database) {
        $this->db = $database;
    }

    public function index(Request $request, Response $response)
    {
        $books = $this->db->query('SELECT * FROM books')
            ->fetchAll();

        return $response->getBody()->write(json_encode($books));
    }

    public function create(Request $request, Response $response)
    {
        $params = $request->getParsedBody();

        // Create the new book
        $statement = $this->db->prepare('INSERT INTO books (title, author_id) VALUES (:title, :author_id)');
        $statement->execute(['title' => $params['title'], 'author_id' => $params['author_id']]);
        $bookId = $this->db->lastInsertId();
//        return $response->getBody()->write(json_encode($bookId));


        $statement = $this->db->prepare('INSERT INTO book_pricing (book_id, currency_id, price) VALUES (:book_id, :currency_id, :price)');
        $statement->execute(['book_id' => $bookId, 'currency_id' => $params['currency_id'], 'price' => $params['price']]);

        // Fetch the book we just created so we can return it in the response
        $stmt = $this->db->prepare('SELECT * FROM books WHERE id =:book_id');
        $stmt->execute(['book_id' => $bookId]);
        $return = $stmt->fetchAll();

        return $response->getBody()->write(json_encode($return));
    }

    public function update(Request $request, Response $response) {
        $data = $request->getParsedBody();

        $this->db->prepare(
        'UPDATE books, book_pricing 
                SET books.title=:title,
                    books.author_id=:author_id,
                    book_pricing.price=:price
                WHERE books.id = book_pricing.book_id AND books.id=:id'
        )->execute($data);

        // Fetch the book we just updated so we can return it in the response
        $statement = $this->db->prepare(
            'SELECT books.*, book_pricing.price FROM books
                    LEFT JOIN book_pricing ON book_pricing.book_id = books.id
                    WHERE books.id=:id');
        $statement->execute($data);

        $book = $statement->fetch();

        return $response->getBody()->write(json_encode($book));
    }

    public function view(Request $request, Response $response, array $data)
    {
        $statement = $this->db->prepare(
            'SELECT books.*, book_pricing.price FROM books
                    LEFT JOIN book_pricing ON book_pricing.book_id = books.id
                    WHERE books.id=:id');
        $statement->execute($data);
        $book = $statement->fetch();

        return $response->getBody()->write(json_encode($book));
    }

    public function delete (Request $request, Response $response, array $data)
    {
        if (empty($data) || isset($data['id']) && empty($data['id'])) {
            $response->withStatus(404);
            return $response->getBody()->write(json_encode(['success' => false]));
        }


//        $db = new \PDO('mysql:host=database;dbname=assess_db', 'root', 'secret');
//        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

        $selectStatement = $this->db->prepare(
        'SELECT id from books
                WHERE books.id=:id'
        );

        $selectStatement->execute($data);
        $book = $selectStatement->fetch();

        if (empty($book)) {
            $response->withStatus(404);
            return $response->getBody()->write(json_encode(['success' => false]));
        }

        $statement = $this->db->prepare(
            'DELETE FROM  books, books.id=:id book_pricing WHERE book_pricing.book_id=:id'
        );

        $deleteSuccess = $statement->execute($data);

        return $response->getBody()->write(json_encode(['success' => $deleteSuccess]));
    }

    private function dump($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        exit;
    }
}
