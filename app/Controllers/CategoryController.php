<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = (new \App\Models\Category())->getAll();
        $content = null;
        include __DIR__ . '/../Views/categories_index.php';
    }
    public function insertView() {
        require_once __DIR__ . '/../Views/categories_add.php';
    }
    public function insert() {
        // Xử lý thêm thể loại
    }
    public function edit($id) {
        $category = (new Category())->select('SELECT * FROM categories WHERE id = ?', [$id], true);
        require_once __DIR__ . '/../Views/categories_edit.php';
    }
    public function update($id) {
        // Xử lý cập nhật thể loại
    }
    public function delete($id) {
        // Xử lý xóa thể loại
    }
}
