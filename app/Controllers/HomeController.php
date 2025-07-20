<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\Readers;
use App\Models\BorrowSlips;
use App\Core\Session;

class HomeController extends BaseAuthController
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = \App\Core\Database::getInstance()->getConnection();
            $db->beginTransaction();
            try {
                $phone = $_POST['phone'] ?? '';
                $reader_name = $_POST['reader_name'] ?? '';
                $due_date = $_POST['due_date'] ?? '';
                $book_ids = isset($_POST['book_ids']) ? explode(',', $_POST['book_ids']) : [];
                $readerModel = new Readers();
                $reader = $readerModel->getReaderByPhone($phone);
                if ($reader && !empty($reader['data'])) {
                    $reader_id = $reader['data']['id'];
                    $readerModel->increaseBorrowCount($reader_id);
                } else {
                    $create = $readerModel->createReader([
                        'name' => $reader_name,
                        'phone' => $phone
                    ]);
                    if ($create['status']) {
                        $reader = $readerModel->getReaderByPhone($phone);
                        $reader_id = $reader['data']['id'];
                        $readerModel->increaseBorrowCount($reader_id);
                    } else {
                        $db->rollBack();
                        Session::flash('message', 'Không thể tạo độc giả mới!');
                        Session::flash('status', false);
                        header('Location: /');
                        exit;
                    }
                }
                $borrowSlipModel = new BorrowSlips();
                $data = [
                    'reader_id' => $reader_id,
                    'due_date' => $due_date,
                    'phone' => $phone
                ];
                $result = $borrowSlipModel->createBorrowSlip($data);
                if ($result['status']) {
                    $borrow_slip_id = $borrowSlipModel->getLastInsertId();
                    // Insert chi tiết phiếu mượn
                    foreach ($book_ids as $book_id) {
                        if ($book_id) {
                            $query = "INSERT INTO borrow_slip_details (borrow_slip_id, book_id, quantity, due_date) VALUES (?, ?, 1, ?)";
                            $borrowSlipModel->insert($query, [$borrow_slip_id, $book_id, $due_date]);
                        }
                    }
                    $db->commit();
                    Session::flash('message', 'Tạo phiếu mượn thành công!');
                    Session::flash('status', true);
                } else {
                    $db->rollBack();
                    Session::flash('message', $result['message']);
                    Session::flash('status', false);
                }
                header('Location: /');
                exit;
            } catch (\Exception $e) {
                $db->rollBack();
                Session::flash('message', 'Lỗi hệ thống: ' . $e->getMessage());
                Session::flash('status', false);
                header('Location: /');
                exit;
            }
        } else {
            $this->view('home/home');
        }
    }
} 