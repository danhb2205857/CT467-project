<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\Books;

class BooksController extends BaseAuthController
{
    private $book;

    public function __construct()
    {
        $this->book = new Books();
    }

    public function index()
    {
        $result = $this->book->getAllBooks();
        $this->view('books/index', [
            'books' => $result['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'author_id' => $_POST['author_id'] ?? '',
                'category_id' => $_POST['category_id'] ?? '',
                'publish_year' => $_POST['publish_year'] ?? '',
                'publisher' => $_POST['publisher'] ?? '',
                'quantity' => $_POST['quantity'] ?? 0,
            ];
            $result = $this->book->createBook($data);
            $this->view('book/add', [
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        } else {
            $this->view('book/add');
        }
    }

    public function editView($id)
    {
        $result = $this->book->getBookById($id);
        $this->view('book/edit', [
            'book' => $result['data'] ?? null,
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'author_id' => $_POST['author_id'] ?? '',
                'category_id' => $_POST['category_id'] ?? '',
                'publish_year' => $_POST['publish_year'] ?? '',
                'publisher' => $_POST['publisher'] ?? '',
                'quantity' => $_POST['quantity'] ?? 0,
            ];
            $result = $this->book->updateBook($id, $data);
            $book = $this->book->getBookById($id);
            $this->view('book/edit', [
                'book' => $book['data'] ?? null,
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        }
    }

    public function delete($id)
    {
        $result = $this->book->deleteBook($id);
        $books = $this->book->getAllBooks();
        $this->view('book/index', [
            'books' => $books['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
