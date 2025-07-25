<?php

namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\Authors;
use App\Core\Session;
use App\Traits\ExcelExportTrait;

class AuthorsController extends BaseAuthController
{
    use ExcelExportTrait;

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
    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $result = $this->author->createAuthor($data);
            if ($result['status']) {
                $this->logCrudAction('CREATE', 'authors', null, null, $data);
            }
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /authors');
            exit;
        }
    }
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $old = $this->author->getAuthorById($id)['data'] ?? null;
            $result = $this->author->updateAuthor($id, $data);
            if ($result['status']) {
                $this->logCrudAction('UPDATE', 'authors', $id, $old, $data);
            }
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /authors');
            exit;
        }
    }
    public function delete($id)
    {
        $old = $this->author->getAuthorById($id)['data'] ?? null;
        $result = $this->author->deleteAuthor($id);
        if ($result['status']) {
            $this->logCrudAction('DELETE', 'authors', $id, $old, null);
        }
        Session::flash('message', $result['message']);
        Session::flash('status', $result['status']);
        header('Location: /authors');
        exit;
    }
}
