<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $result = (new \App\Models\Author())->getAllAuthors();
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
            $result = (new \App\Models\Author())->createAuthor($data);
            $this->view('author/add', [
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        } else {
            $this->view('author/add');
        }
    }
    public function edit($id) {
        $result = (new Author())->getAuthorById($id);
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
            $result = (new \App\Models\Author())->updateAuthor($id, $data);
            $author = (new \App\Models\Author())->getAuthorById($id);
            $this->view('author/edit', [
                'author' => $author['data'] ?? null,
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        }
    }
    public function delete($id) {
        $result = (new \App\Models\Author())->deleteAuthor($id);
        $authors = (new \App\Models\Author())->getAllAuthors();
        $this->view('author/index', [
            'authors' => $authors['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
