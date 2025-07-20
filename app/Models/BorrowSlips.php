<?php

namespace App\Models;

use App\Core\Model;

class BorrowSlips extends Model
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
            $query = 'SELECT bs.*, r.name as name FROM borrow_slips bs
          LEFT JOIN readers r ON bs.reader_id = r.id
          ORDER BY 
            CASE 
              WHEN bs.status = 2 THEN 2
              WHEN bs.status = 0 THEN 1
              WHEN bs.status = 1 THEN 0
              ELSE 3
            END,
            CASE 
              WHEN bs.status = 1 THEN bs.return_date
              ELSE NULL
            END,
            CASE 
              WHEN bs.status = 0 THEN bs.borrow_date
              ELSE NULL
            END
             DESC';
            $data = $this->select($query);
            return [
                'status' => true,
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
            $query = 'SELECT bs.*, r.name as reader_name FROM borrow_slips bs
                    LEFT JOIN readers r ON bs.reader_id = r.id
                    WHERE bs.id = :id LIMIT 1';
            $data = $this->select($query, ['id' => $id], true);
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
            $query = "INSERT INTO borrow_slips (reader_id, due_date, phone) VALUES (:reader_id, :due_date, :phone)";
            $params = [
                'reader_id' => $data['reader_id'],
                'due_date' => $data['due_date'],
                'phone' => $data['phone']
            ];
            $result = $this->insert($query, $params);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Thêm phiếu mượn thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Thêm phiếu mượn thất bại. Lỗi: ' . ($this->error ?? 'Không rõ nguyên nhân')
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
            $query = "UPDATE borrow_slips SET reader_id = :reader_id, borrow_date = :borrow_date, due_date = :due_date, return_date = :return_date, status = :status WHERE id = :id";
            $params = [
                'id' => $id,
                'reader_id' => $data['reader_id'],
                'borrow_date' => $data['borrow_date'] ?? null,
                'due_date' => $data['due_date'] ?? null,
                'return_date' => $data['return_date'] ?? null,
                'status' => $data['status'] ?? null
            ];
            $result = $this->update($query, $params);
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
            $query = "DELETE FROM borrow_slips WHERE id = :id";
            $result = $this->delete($query, ['id' => $id]);
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
    public function submitBorrowSlip($id)
    {
        try {
            $query = "UPDATE borrow_slips SET status = '1', return_date = NOW() WHERE id = :id";
            $params = [
                'id' => $id
            ];
            $result = $this->update($query, $params);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Cập nhật phiếu mượn thành công (đã trả sách)'
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

    public function submitBorrowSlipAndDetails($id)
    {
        try {
            $query1 = "UPDATE borrow_slip_details SET return_date = NOW() 
                        WHERE borrow_slip_id = :id AND (return_date IS NULL OR return_date = 0)";
            $params1 = ['id' => $id];
            $result1 = $this->update($query1, $params1);

            $query2 = "UPDATE borrow_slips SET status = '1', return_date = NOW() 
                        WHERE id = :id";
            $params2 = ['id' => $id];
            $result2 = $this->update($query2, $params2);

            if ($result1 !== false && $result2 !== false) {
                return ['status' => true, 'message' => 'Đã trả tất cả sách thành công!'];
            } else {
                return ['status' => false, 'message' => 'Trả sách thất bại!'];
            }
        } catch (\Exception $e) {
            return ['status' => false, 'message' => 'Trả sách thất bại!'];
        }
    }

    public function getFilteredBorrowSlips($filters = [])
    {
        try {
            $where = [];
            $params = [];
            $sql = 'SELECT bs.*, r.name as name 
            FROM borrow_slips bs 
            LEFT JOIN readers r ON bs.reader_id = r.id';
            if (!empty($filters['phone'])) {
                $where[] = 'r.phone LIKE :phone';
                $params['phone'] = '%' . $filters['phone'] . '%';
            }
            if (!empty($filters['status'])) {
                $where[] = 'bs.status = :status';
                $params['status'] = (string)$filters['status'];
            }
            if ($where) {
                $sql .= ' WHERE ' . implode(' AND ', $where);
            }
            $data = $this->select($sql, $params);
            return [
                'status' => true,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lọc phiếu mượn: ' . $e->getMessage()
            ];
        }
    }
}
