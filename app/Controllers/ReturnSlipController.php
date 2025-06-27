<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ReturnSlip;

class ReturnSlipController extends Controller
{
    public function index()
    {
        $result = (new \App\Models\ReturnSlip())->getAllReturnSlips();
        $this->view('returnslip/index', [
            'returnslips' => $result['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
    public function insertView() {
        $this->view('returnslip/add');
    }
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'borrow_slip_detail_id' => $_POST['borrow_slip_detail_id'] ?? '',
                'return_date' => $_POST['return_date'] ?? '',
                'fine' => $_POST['fine'] ?? 0
            ];
            $result = (new \App\Models\ReturnSlip())->createReturnSlip($data);
            $this->view('returnslip/add', [
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        } else {
            $this->view('returnslip/add');
        }
    }
    public function edit($id) {
        $result = (new ReturnSlip())->getReturnSlipById($id);
        $this->view('returnslip/edit', [
            'slip' => $result['data'] ?? null,
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'borrow_slip_detail_id' => $_POST['borrow_slip_detail_id'] ?? '',
                'return_date' => $_POST['return_date'] ?? '',
                'fine' => $_POST['fine'] ?? 0
            ];
            $result = (new \App\Models\ReturnSlip())->updateReturnSlip($id, $data);
            $slip = (new \App\Models\ReturnSlip())->getReturnSlipById($id);
            $this->view('returnslip/edit', [
                'slip' => $slip['data'] ?? null,
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        }
    }
    public function delete($id) {
        $result = (new \App\Models\ReturnSlip())->deleteReturnSlip($id);
        $returnslips = (new \App\Models\ReturnSlip())->getAllReturnSlips();
        $this->view('returnslip/index', [
            'returnslips' => $returnslips['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
