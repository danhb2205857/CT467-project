<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = (new \App\Models\Author())->getAll();
        $content = null;
        include __DIR__ . '/../Views/authors_index.php';
    }
    public function insertView() {
        require_once __DIR__ . '/../Views/authors_add.php';
    }
    public function insert() {
        // Xử lý thêm tác giả
    }
    public function edit($id) {
        // Lấy thông tin tác giả
        $author = (new Author())->select('SELECT * FROM authors WHERE id = ?', [$id], true);
        require_once __DIR__ . '/../Views/authors_edit.php';
    }
    public function update($id) {
        // Xử lý cập nhật tác giả
    }
    public function delete($id) {
        // Xử lý xóa tác giả
    }
}
