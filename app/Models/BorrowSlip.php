<?php
namespace App\Models;

use App\Core\Model;

class BorrowSlip extends Model
{
    public $id;
    public $reader_id;
    public $borrow_date;
    public $return_date;
    public $status;
    
    protected $table = 'borrow_slips';
    protected $primaryKey = 'id';

    public function __construct($data = [])
    {
        parent::__construct();
        $this->id = $data['id'] ?? null;
        $this->reader_id = $data['reader_id'] ?? null;
        $this->borrow_date = $data['borrow_date'] ?? '';
        $this->return_date = $data['return_date'] ?? '';
        $this->status = $data['status'] ?? '';
    }

    public function getAllBorrowSlips()
    {
        try {
            $sql = 'SELECT bs.*, r.name as reader_name FROM borrow_slips bs
                    LEFT JOIN readers r ON bs.reader_id = r.id';
            $data = $this->select($sql);
            return [
                'status' => true,
                'message' => 'Lấy danh sách phiếu mượn thành công',
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy danh sách phiếu mượn: ' . $e->getMessage()
            ];
        }
    }

    public function getBorrowSlipById($id)
    {
        try {
            $data = $this->getById($id);
            if ($data) {
                return [
                    'status' => true,
                    'message' => 'Lấy phiếu mượn thành công',
                    'data' => $data
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy phiếu mượn'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy phiếu mượn: ' . $e->getMessage()
            ];
        }
    }

    public function createBorrowSlip($data)
    {
        try {
            $result = $this->create($data);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Thêm phiếu mượn thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Thêm phiếu mượn thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi thêm phiếu mượn: ' . $e->getMessage()
            ];
        }
    }

    public function updateBorrowSlip($id, $data)
    {
        try {
            $result = $this->updateById($id, $data);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Cập nhật phiếu mượn thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Cập nhật phiếu mượn thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi cập nhật phiếu mượn: ' . $e->getMessage()
            ];
        }
    }

    public function deleteBorrowSlip($id)
    {
        try {
            $result = $this->deleteById($id);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Xóa phiếu mượn thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Xóa phiếu mượn thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi xóa phiếu mượn: ' . $e->getMessage()
            ];
        }
    }
}
