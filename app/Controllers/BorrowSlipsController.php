<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\BorrowSlips;
use App\Core\Session;

class BorrowSlipsController extends BaseAuthController
{
    private $borrowSlip;

    public function __construct()
    {
        $this->borrowSlip = new BorrowSlips();
    }
    public function index()
    {
        $filters = [
            'reader_name' => $_GET['reader_name'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];
        $hasFilter = false;
        foreach ($filters as $v) {
            if ($v !== '' && $v !== null) {
                $hasFilter = true;
                break;
            }
        }
        if ($hasFilter) {
            $result = $this->borrowSlip->getFilteredBorrowSlips($filters);
        } else {
            $result = $this->borrowSlip->getAllBorrowSlips();
        }
        $readers = (new \App\Models\Readers())->getAllReaders()['data'] ?? [];
        $message = Session::flash('message');
        $status = Session::flash('status');
        $this->view('borrow_slips/index', [
            'borrowslips' => $result['data'] ?? [],
            'readers' => $readers,
            'filters' => $filters,
            'message' => $message !== null ? $message : ($result['message'] ?? ''),
            'status' => $status !== null ? $status : ($result['status'] ?? null)
        ]);
    }

    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'reader_id' => $_POST['reader_id'] ?? '',
                'due_date' => $_POST['due_date'] ?? ''
            ];
            $result = $this->borrowSlip->createBorrowSlip($data);
            if ($result['status']) {
                $this->logCrudAction('CREATE', 'borrow_slips', null, null, $data);
            }
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /borrowslips');
            exit;
        } else {
            $this->view('borrow_slips/index');
        }
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
