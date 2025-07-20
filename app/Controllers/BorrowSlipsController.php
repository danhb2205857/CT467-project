<?php

namespace App\Controllers;

use App\Constants\Index;
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
            'phone' => $_GET['phone'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];
        $hasFilter = false;
        foreach ($filters as $v) {
            if ($v !== '' && $v !== null) {
                $hasFilter = true;
                break;
            }
        }
        $result = [];

        if ($filters['status'] !== '' && $filters['phone'] === '') {
            // Gọi procedure lọc theo trạng thái
            $db = \App\Core\Database::getInstance()->getConnection();
            $stmt = $db->prepare("CALL sp_get_borrow_slips_by_status(:status)");
            $stmt->bindValue(':status', $filters['status']);
            $stmt->execute();
            $result['data'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $stmt->closeCursor();
        } else if ($hasFilter) {
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

    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = \App\Core\Database::getInstance()->getConnection();
            $db->beginTransaction();
            try {
                $phone = $_POST['phone'] ?? '';
                $reader_name = $_POST['reader_name'] ?? '';
                $due_date = $_POST['due_date'] ?? '';
                $readerModel = new \App\Models\Readers();
                $reader = $readerModel->getReaderByPhone($phone);
                if ($reader && !empty($reader['data'])) {
                    $reader_id = $reader['data']['id'];
                } else {
                    $create = $readerModel->createReader([
                        'name' => $reader_name,
                        'phone' => $phone
                    ]);
                    if ($create['status']) {
                        $reader = $readerModel->getReaderByPhone($phone);
                        $reader_id = $reader['data']['id'];
                    } else {
                        $db->rollBack();
                        Session::flash('message', 'Không thể tạo độc giả mới!');
                        Session::flash('status', false);
                        $message = Session::flash('message');
                        $status = Session::flash('status');
                        $this->view('home/home', [
                            'message' => $message !== null ? $message : ($result['message'] ?? ''),
                            'status' => $status !== null ? $status : ($result['status'] ?? null)
                        ]);
                        exit;
                    }
                }
                $data = [
                    'reader_id' => $reader_id,
                    'due_date' => $due_date,
                    'phone' => $reader['data']['phone']
                ];
                $result = $this->borrowSlip->createBorrowSlip($data);
                if ($result['status']) {
                    $borrow_slip_id = $this->borrowSlip->getLastInsertId();
                    $book_ids = isset($_POST['book_ids']) ? explode(',', $_POST['book_ids']) : [];
                    foreach ($book_ids as $book_id) {
                        if ($book_id) {
                            $query = "INSERT INTO borrow_slip_details (borrow_slip_id, book_id, quantity, due_date) VALUES (?, ?, 1, ?)";
                            $this->borrowSlip->insert($query, [$borrow_slip_id, $book_id, $due_date]);
                        }
                    }
                    $this->logCrudAction('CREATE', 'borrow_slips', null, null, $data);
                    $db->commit();
                } else {
                    $db->rollBack();
                }
                Session::flash('message', 'Tạo phiếu mượn thành công!');
                Session::flash('status', true);
                header('Location: ' . '/');
                // $message = Session::flash('message');
                // $status = Session::flash('status');
                // $this->view('home/home', [
                //     'message' => $message !== null ? $message : ($result['message'] ?? ''),
                //     'status' => $status !== null ? $status : ($result['status'] ?? null)
                // ]);
                exit;
            } catch (\Exception $e) {
                $db->rollBack();
                Session::flash('message', 'Lỗi hệ thống: ');
                Session::flash('status', false);
                $message = Session::flash('message');
                $status = Session::flash('status');
                $this->view('home/home', [
                    'message' => $message !== null ? $message : ($result['message'] ?? ''),
                    'status' => $status !== null ? $status : ($result['status'] ?? null)
                ]);
                exit;
            }
        }
    }

    public function update($id)
    {
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
    public function delete($id)
    {
        $result = $this->borrowSlip->deleteBorrowSlip($id);
        if ($result['status']) {
            header('Location: /borrowslips');
        }
    }
    public function submit($id)
    {
        $result = $this->borrowSlip->submitBorrowSlip($id);
        if ($result['status']) {
            header('Location: /borrowslips');
        }
    }

    public function details($id)
    {
        $borrowSlip = $this->borrowSlip->getBorrowSlipById($id);
        $detailsModel = new \App\Models\BorrowSlipDetails();
        $books = $detailsModel->getDetailsByBorrowSlipId($id);
        $this->json([
            'status' => $borrowSlip['status'] && $books !== false,
            'slip' => $borrowSlip['data'] ?? null,
            'books' => $books ?? [],
        ]);
    }

    public function submitBook($detail_id)
    {
        $db = \App\Core\Database::getInstance()->getConnection();
        $query = "UPDATE borrow_slip_details SET returned = 1, return_date = NOW() WHERE id = ?";
        $stmt = $db->prepare($query);
        $success = $stmt->execute([$detail_id]);
        $this->json([
            'status' => $success,
            'message' => $success ? 'Đã trả sách thành công!' : 'Trả sách thất bại!'
        ]);
    }

    public function submitAllBooks($slip_id)
    {
        $db = \App\Core\Database::getInstance()->getConnection();
        $query = "UPDATE borrow_slip_details SET returned = 1, return_date = NOW() WHERE borrow_slip_id = ? AND (returned IS NULL OR returned = 0)";
        $stmt = $db->prepare($query);
        $success = $stmt->execute([$slip_id]);
        $this->json([
            'status' => $success,
            'message' => $success ? 'Đã trả tất cả sách thành công!' : 'Trả sách thất bại!'
        ]);
    }
}
