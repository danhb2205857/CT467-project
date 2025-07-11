<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\Authors;
use App\Core\Session;

class AuthorsController extends BaseAuthController
{   
    private $author;

    public function __construct()
    {
        $this->author = new Authors();
    }
    public function index()
    {
        $result = $this->author->getAllAuthors();
        $message = Session::flash('message');
        $status = Session::flash('status');
        $this->view('authors/index', [
            'authors' => $result['data'] ?? [],
            'message' => $message !== null ? $message : ($result['message'] ?? ''),
            'status' => $status !== null ? $status : ($result['status'] ?? null)
        ]);
    }
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $result = $this->author->createAuthor($data);
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /authors');
            exit;
        }
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $result = $this->author->updateAuthor($id, $data);
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /authors');
            exit;
        }
    }
    public function delete($id) {
        $result = $this->author->deleteAuthor($id);
        Session::flash('message', $result['message']);
        Session::flash('status', $result['status']);
        header('Location: /authors');
        exit;
    }
}
