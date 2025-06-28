<?php
namespace App\Models;

use App\Core\Model;

class ReturnSlip extends Model
{
    public $id;
    public $borrow_slip_detail_id;
    public $return_date;
    public $fine;
    
    protected $table = 'return_slips';
    protected $primaryKey = 'id';

    public function __construct($data = [])
    {
        parent::__construct();
        $this->id = $data['id'] ?? null;
        $this->borrow_slip_detail_id = $data['borrow_slip_detail_id'] ?? null;
        $this->return_date = $data['return_date'] ?? '';
        $this->fine = $data['fine'] ?? 0;
    }

    public function getAllReturnSlips()
    {
        try {
            $sql = 'SELECT rs.*, r.name as reader_name, b.title as book_title FROM return_slips rs
                    LEFT JOIN borrow_slip_details bsd ON rs.borrow_slip_detail_id = bsd.id
                    LEFT JOIN borrow_slips bs ON bsd.borrow_slip_id = bs.id
                    LEFT JOIN readers r ON bs.reader_id = r.id
                    LEFT JOIN books b ON bsd.book_id = b.id';
            $data = $this->select($sql);
            return [
                'status' => true,
                'message' => 'Lấy danh sách phiếu trả thành công',
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy danh sách phiếu trả: ' . $e->getMessage()
            ];
        }
    }

    public function getReturnSlipById($id)
    {
        try {
            $data = $this->getById($id);
            if ($data) {
                return [
                    'status' => true,
                    'message' => 'Lấy phiếu trả thành công',
                    'data' => $data
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy phiếu trả'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy phiếu trả: ' . $e->getMessage()
            ];
        }
    }

    public function createReturnSlip($data)
    {
        try {
            $result = $this->create($data);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Thêm phiếu trả thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Thêm phiếu trả thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi thêm phiếu trả: ' . $e->getMessage()
            ];
        }
    }

    public function updateReturnSlip($id, $data)
    {
        try {
            $result = $this->updateById($id, $data);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Cập nhật phiếu trả thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Cập nhật phiếu trả thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi cập nhật phiếu trả: ' . $e->getMessage()
            ];
        }
    }

    public function deleteReturnSlip($id)
    {
        try {
            $result = $this->deleteById($id);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Xóa phiếu trả thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Xóa phiếu trả thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi xóa phiếu trả: ' . $e->getMessage()
            ];
        }
    }
}
