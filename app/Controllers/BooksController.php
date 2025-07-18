<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\Books;
use App\Core\Session;

class BooksController extends BaseAuthController
{
    private $book;

    public function __construct()
    {
        $this->book = new Books();
    }

    public function index()
    {
        $filters = [
            'title' => $_GET['title'] ?? '',
            'author' => $_GET['author'] ?? '',
            'category' => $_GET['category'] ?? '',
            'publisher' => $_GET['publisher'] ?? '',
            'publish_year' => $_GET['publish_year'] ?? '',
        ];
        $hasFilter = false;
        foreach ($filters as $v) {
            if ($v !== '' && $v !== null) {
                $hasFilter = true;
                break;
            }
        }
        if ($hasFilter) {
            $result = $this->book->getFilteredBooks($filters);
        } else {
            $result = $this->book->getAllBooks();
        }
        $authors = (new \App\Models\Authors())->getAllAuthors()['data'] ?? [];
        $categories = (new \App\Models\Categories())->getAllCategories()['data'] ?? [];
        $message = Session::flash('message');
        $status = Session::flash('status');
        $this->view('books/index', [
            'books' => $result['data'] ?? [],
            'authors' => $authors,
            'categories' => $categories,
            'message' => $message !== null ? $message : ($result['message'] ?? ''),
            'status' => $status !== null ? $status : ($result['status'] ?? null)
        ]);
    }

    public function insert()
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
            if ($result['status']) {
                $this->logCrudAction('CREATE', 'books', null, null, $data);
            }
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /books');
            exit;
        }
    }

    public function update($id)
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
            $old = $this->book->getBookById($id)['data'] ?? null;
            $result = $this->book->updateBook($id, $data);
            if ($result['status']) {
                $this->logCrudAction('UPDATE', 'books', $id, $old, $data);
            }
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /books');
            exit;
        }
    }

    public function delete($id)
    {
        $old = $this->book->getBookById($id)['data'] ?? null;
        $result = $this->book->deleteBook($id);
        if ($result['status']) {
            $this->logCrudAction('DELETE', 'books', $id, $old, null);
        }
        Session::flash('message', $result['message']);
        Session::flash('status', $result['status']);
        header('Location: /books');
        exit;
    }
}
