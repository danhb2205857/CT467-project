<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $result = (new \App\Models\Category())->getAllCategories();
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
            $result = (new \App\Models\Category())->createCategory($data);
            $this->view('category/add', [
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        } else {
            $this->view('category/add');
        }
    }
    public function edit($id) {
        $result = (new Category())->getCategoryById($id);
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
            $result = (new \App\Models\Category())->updateCategory($id, $data);
            $category = (new \App\Models\Category())->getCategoryById($id);
            $this->view('category/edit', [
                'category' => $category['data'] ?? null,
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        }
    }
    public function delete($id) {
        $result = (new \App\Models\Category())->deleteCategory($id);
        $categories = (new \App\Models\Category())->getAllCategories();
        $this->view('category/index', [
            'categories' => $categories['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
