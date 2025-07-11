<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\Categories;

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
        $this->view('category/index', [
            'categories' => $result['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
    public function insertView() {
        $this->view('category/add');
    }
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $result = $this->category->createCategory($data);
            $this->view('category/add', [
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        } else {
            $this->view('category/add');
        }
    }
    public function edit($id) {
        $result = $this->category->getCategoryById($id);
        $this->view('category/edit', [
            'category' => $result['data'] ?? null,
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $result = $this->category->updateCategory($id, $data);
            $category = $this->category->getCategoryById($id);
            $this->view('category/edit', [
                'category' => $category['data'] ?? null,
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        }
    }
    public function delete($id) {
        $result = $this->category->deleteCategory($id);
        $categories = $this->category->getAllCategories();
        $this->view('category/index', [
            'categories' => $categories['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
