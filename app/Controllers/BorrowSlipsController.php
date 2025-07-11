<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\BorrowSlips;

class BorrowSlipsController extends BaseAuthController
{
    private $borrowSlip;

    public function __construct()
    {
        $this->borrowSlip = new BorrowSlips();
    }
    public function index()
    {
        $result = $this->borrowSlip->getAllBorrowSlips();
        $this->view('borrowslip/index', [
            'borrowslips' => $result['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
    public function insertView() {
        $this->view('borrowslip/add');
    }
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'reader_id' => $_POST['reader_id'] ?? '',
                'borrow_date' => $_POST['borrow_date'] ?? '',
                'return_date' => $_POST['return_date'] ?? '',
                'status' => $_POST['status'] ?? ''
            ];
            $result = $this->borrowSlip->createBorrowSlip($data);
            $this->view('borrowslip/add', [
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        } else {
            $this->view('borrowslip/add');
        }
    }
    public function edit($id) {
        $result = $this->borrowSlip->getBorrowSlipById($id);
        $this->view('borrowslip/edit', [
            'slip' => $result['data'] ?? null,
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'reader_id' => $_POST['reader_id'] ?? '',
                'borrow_date' => $_POST['borrow_date'] ?? '',
                'return_date' => $_POST['return_date'] ?? '',
                'status' => $_POST['status'] ?? ''
            ];
            $result = $this->borrowSlip->updateBorrowSlip($id, $data);
            $slip = $this->borrowSlip->getBorrowSlipById($id);
            $this->view('borrowslip/edit', [
                'slip' => $slip['data'] ?? null,
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        }
    }
    public function delete($id) {
        $result = $this->borrowSlip->deleteBorrowSlip($id);
        $borrowslips = $this->borrowSlip->getAllBorrowSlips();
        $this->view('borrowslip/index', [
            'borrowslips' => $borrowslips['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
