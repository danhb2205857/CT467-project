<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Author;

class AuthorController extends Controller
{
    private $author;

    public function __construct()
    {
        $this->author = new Author();
    }
    public function index()
    {
        $result = $this->author->getAllAuthors();
        $this->view('author/index', [
            'authors' => $result['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
    public function insertView() {
        $this->view('author/add');
    }
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $result = $this->author->createAuthor($data);
            $this->view('author/add', [
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        } else {
            $this->view('author/add');
        }
    }
    public function edit($id) {
        $result = $this->author->getAuthorById($id);
        $this->view('author/edit', [
            'author' => $result['data'] ?? null,
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $result = $this->author->updateAuthor($id, $data);
            $author = $this->author->getAuthorById($id);
            $this->view('author/edit', [
                'author' => $author['data'] ?? null,
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        }
    }
    public function delete($id) {
        $result = $this->author->deleteAuthor($id);
        $authors = $this->author->getAllAuthors();
        $this->view('author/index', [
            'authors' => $authors['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
