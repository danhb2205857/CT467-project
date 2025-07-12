<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\Categories;
use App\Core\Session;

class CategoriesController extends BaseAuthController
{
    private $category;

    public function __construct()
    {
        $this->category = new Categories();
    }
    public function index()
    {
        $result = $this->category->getAllCategories();
        $message = Session::flash('message');
        $status = Session::flash('status');
        $this->view('categories/index', [
            'categories' => $result['data'] ?? [],
            'message' => $message !== null ? $message : ($result['message'] ?? ''),
            'status' => $status !== null ? $status : ($result['status'] ?? null)
        ]);
    }
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $result = $this->category->createCategory($data);
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /categories');
            exit;
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $result = $this->category->updateCategory($id, $data);
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /categories');
            exit;
        }
    }
    public function delete($id) {
        $result = $this->category->deleteCategory($id);
        Session::flash('message', $result['message']);
        Session::flash('status', $result['status']);
        header('Location: /categories');
        exit;
    }
}
