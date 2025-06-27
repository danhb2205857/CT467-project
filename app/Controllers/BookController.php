<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $sql = 'SELECT b.*, a.name as author_name, c.name as category_name FROM books b
                LEFT JOIN authors a ON b.author_id = a.id
                LEFT JOIN categories c ON b.category_id = c.id';
        $books = (new \App\Models\Book())->select($sql);
        $content = null;
        include __DIR__ . '/../Views/books_index.php';
    }

    public function addView()
    {
        $this->view('books_add');
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
            (new Book())->create($data);
            $this->redirect('/books');
        }
    }

    public function editView($id)
    {
        $book = (new Book())->getById($id);
        $this->view('books_edit', ['book' => $book]);
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
            (new Book())->updateById($id, $data);
            $this->redirect('/books');
        }
    }

    public function delete($id)
    {
        (new Book())->deleteById($id);
        $this->redirect('/books');
    }
}
