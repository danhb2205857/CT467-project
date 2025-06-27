<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\BorrowSlip;

class BorrowSlipController extends Controller
{
    public function index()
    {
        $sql = 'SELECT bs.*, r.name as reader_name FROM borrow_slips bs
                LEFT JOIN readers r ON bs.reader_id = r.id';
        $borrowslips = (new \App\Models\BorrowSlip())->select($sql);
        $content = null;
        include __DIR__ . '/../Views/borrowslips_index.php';
    }
    public function insertView() {
        require_once __DIR__ . '/../Views/borrowslips_add.php';
    }
    public function insert() {
        // Xử lý thêm phiếu mượn
    }
    public function edit($id) {
        $slip = (new BorrowSlip())->select('SELECT * FROM borrow_slips WHERE id = ?', [$id], true);
        require_once __DIR__ . '/../Views/borrowslips_edit.php';
    }
    public function update($id) {
        // Xử lý cập nhật phiếu mượn
    }
    public function delete($id) {
        // Xử lý xóa phiếu mượn
    }
}
