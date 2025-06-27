<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Reader;

class ReaderController extends Controller
{
    public function index()
    {
        $readers = (new \App\Models\Reader())->getAll();
        $content = null;
        include __DIR__ . '/../Views/readers_index.php';
    }
    public function insertView() {
        require_once __DIR__ . '/../Views/readers_add.php';
    }
    public function insert() {
        // Xử lý thêm độc giả
    }
    public function edit($id) {
        $reader = (new Reader())->select('SELECT * FROM readers WHERE id = ?', [$id], true);
        require_once __DIR__ . '/../Views/readers_edit.php';
    }
    public function update($id) {
        // Xử lý cập nhật độc giả
    }
    public function delete($id) {
        // Xử lý xóa độc giả
    }
}
