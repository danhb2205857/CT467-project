<?php

namespace App\Controllers;

use App\Constants\Index;
use App\Controllers\BaseAuthController;
use App\Models\BorrowSlips;
use App\Core\Session;
use App\Traits\ExcelExportTrait;

class BorrowSlipsController extends BaseAuthController
{
    use ExcelExportTrait;
    
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
                
                Session::flash('message', 'Tạo phiếu mượn thành công!');
                Session::flash('status', true);
            } else {
                $db->rollBack();
                // Chỉ hiển thị message từ Model, đã được làm sạch
                Session::flash('message', $result['message'] ?? 'Không thể tạo phiếu mượn!');
                Session::flash('status', false);
            }
            
            $message = Session::flash('message');
            $status = Session::flash('status');
            $this->view('home/home', [
                'message' => $message !== null ? $message : ($result['message'] ?? ''),
                'status' => $status !== null ? $status : ($result['status'] ?? null)
            ]);
            exit;
            
        } catch (\PDOException $e) {
            $db->rollBack();
            
            // Bắt lỗi từ trigger - kiểm tra SQLSTATE và message
            if ($e->getCode() == '45000' || strpos($e->getMessage(), 'VALIDATION_ERROR') !== false) {
                // Lỗi validation từ trigger
                $error_message = $e->getMessage();
                // Loại bỏ prefix "VALIDATION_ERROR: " nếu có
                $error_message = str_replace('VALIDATION_ERROR: ', '', $error_message);
                // Loại bỏ thông tin technical không cần thiết
                $error_message = preg_replace('/SQLSTATE\[.*?\]: /', '', $error_message);
                
                Session::flash('message', $error_message);
                Session::flash('status', false);
            } else {
                // Lỗi database khác - chỉ hiển thị message chung
                Session::flash('message', 'Có lỗi xảy ra khi tạo phiếu mượn!');
                Session::flash('status', false);
            }
            
            $message = Session::flash('message');
            $status = Session::flash('status');
            $this->view('home/home', [
                'message' => $message !== null ? $message : '',
                'status' => $status !== null ? $status : false
            ]);
            exit;
            
        } catch (\Exception $e) {
            $db->rollBack();
            
            // Chỉ hiển thị message chung, không hiển thị chi tiết lỗi
            Session::flash('message', 'Có lỗi hệ thống xảy ra!');
            Session::flash('status', false);
            $message = Session::flash('message');
            $status = Session::flash('status');
            
            $this->view('home/home', [
                'message' => $message !== null ? $message : '',
                'status' => $status !== null ? $status : false
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
            $old = $this->borrowSlip->getBorrowSlipById($id)['data'] ?? null;
            $result = $this->borrowSlip->updateBorrowSlip($id, $data);
            if ($result['status']) {
                $this->logCrudAction('UPDATE', 'borrow_slips', $id, $old, $data);
            }
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
        $old = $this->borrowSlip->getBorrowSlipById($id)['data'] ?? null;
        $result = $this->borrowSlip->deleteBorrowSlip($id);
        if ($result['status']) {
            $this->logCrudAction('DELETE', 'borrow_slips', $id, $old, null);
            header('Location: /borrowslips');
        }
    }
    public function submit($id)
    {
        $result = $this->borrowSlip->submitBorrowSlipAndDetails($id);
        if ($result['status']) {
            header('Location: /borrowslips');
        } else {
            // Xử lý lỗi nếu cần
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
    
    /**
     * Xuất Excel danh sách phiếu mượn
     */
    public function exportExcelBorrowslip()
    {
        // Lấy dữ liệu với filter nếu có
        $filters = [
            'phone' => $_GET['phone'] ?? '',
            'status' => $_GET['status'] ?? '',
        ];
        
        $hasFilter = array_filter($filters);
        
        if (!empty($hasFilter)) {
            $result = $this->borrowSlip->getFilteredBorrowSlips($filters);
            $data = $result['data'] ?? [];
        } else {
            $result = $this->borrowSlip->getAllBorrowSlips();
            $data = $result['data'] ?? [];
        }
        
        // Sử dụng trait để xuất Excel
        $this->exportExcel('borrowslips', $data);
    }

}
