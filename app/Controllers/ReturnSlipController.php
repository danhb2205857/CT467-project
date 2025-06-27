<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ReturnSlip;

class ReturnSlipController extends Controller
{
    public function index()
    {
        $sql = 'SELECT rs.*, r.name as reader_name, b.title as book_title FROM return_slips rs
                LEFT JOIN borrow_slip_details bsd ON rs.borrow_slip_detail_id = bsd.id
                LEFT JOIN borrow_slips bs ON bsd.borrow_slip_id = bs.id
                LEFT JOIN readers r ON bs.reader_id = r.id
                LEFT JOIN books b ON bsd.book_id = b.id';
        $returnslips = (new \App\Models\ReturnSlip())->select($sql);
        $content = null;
        include __DIR__ . '/../Views/returnslips_index.php';
    }
    public function insertView() {
        require_once __DIR__ . '/../Views/returnslips_add.php';
    }
    public function insert() {
        // Xử lý thêm phiếu trả
    }
    public function edit($id) {
        $slip = (new ReturnSlip())->select('SELECT * FROM return_slips WHERE id = ?', [$id], true);
        require_once __DIR__ . '/../Views/returnslips_edit.php';
    }
    public function update($id) {
        // Xử lý cập nhật phiếu trả
    }
    public function delete($id) {
        // Xử lý xóa phiếu trả
    }
}
