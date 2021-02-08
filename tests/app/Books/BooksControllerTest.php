<?php

namespace app\Books;

use App\Books\BooksController;
use App\Lib\CurlRequest;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Environment;
use \Slim\Views\PhpRenderer;

class BooksControllerTest extends TestCase
{
    private $curlRequest;
    private $renderer;

    public function setUp():void
    {
        $this->curlRequest = $this->createMock(CurlRequest::class);
        $this->renderer = $this->createMock(PhpRenderer::class);
    }

    public function testIndex() {

        $environment = Environment::mock(['REQUEST_URI' => '/']);
        $request = Request::createFromEnvironment($environment);
        $response = new Response();
        $books = [];
        $authors = [];
        $books[] = (object)[
            'id' => 1,
            'author_id' => 1,
            'title' => 'test book1',
        ];
        $authors[] = (object)[
            'id' => 1,
            'first_name' => 'author one',
            'last_name' => 'dezel',
        ];

        $controller = new BooksController($this->curlRequest, $this->renderer);

        $this->curlRequest
            ->method('execute')
            ->will($this->onConsecutiveCalls(json_encode($books), json_encode($authors)));

        foreach ($books as $key => $book) {
            foreach ($authors as $author) {
                if ($book->author_id == $author->id) {
                    $books[$key]->author = $author;
                }
            }
        }

        $this->renderer->expects($this->once())
            ->method('render')
            ->with($response, 'list.php', ['books' => $books]);


        $controller->index($request, $response);
    }
}
