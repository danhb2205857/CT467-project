<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\ReturnSlips;

class ReturnSlipsController extends BaseAuthController
{
    private $returnSlip;

    public function __construct()
    {
        $this->returnSlip = new ReturnSlips();
    }
    public function index()
    {
        $result = $this->returnSlip->getAllReturnSlips();
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
            $result = $this->returnSlip->createReturnSlip($data);
            $this->view('returnslip/add', [
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        } else {
            $this->view('returnslip/add');
        }
    }
    public function edit($id) {
        $result = $this->returnSlip->getReturnSlipById($id);
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
            $result = $this->returnSlip->updateReturnSlip($id, $data);
            $slip = $this->returnSlip->getReturnSlipById($id);
            $this->view('returnslip/edit', [
                'slip' => $slip['data'] ?? null,
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        }
    }
    public function delete($id) {
        $result = $this->returnSlip->deleteReturnSlip($id);
        $returnslips = $this->returnSlip->getAllReturnSlips();
        $this->view('returnslip/index', [
            'returnslips' => $returnslips['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
