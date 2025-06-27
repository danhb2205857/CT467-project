<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $result = (new \App\Models\Book())->getAllBooks();
        $this->view('book/index', [
            'books' => $result['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }

    public function addView()
    {
        $this->view('book/add');
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
            $result = (new Book())->createBook($data);
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
        $result = (new Book())->getBookById($id);
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
            $result = (new Book())->updateBook($id, $data);
            $book = (new Book())->getBookById($id);
            $this->view('book/edit', [
                'book' => $book['data'] ?? null,
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        }
    }

    public function delete($id)
    {
        $result = (new Book())->deleteBook($id);
        $books = (new Book())->getAllBooks();
        $this->view('book/index', [
            'books' => $books['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
