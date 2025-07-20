<?php
namespace App\Models;

use App\Core\Model;

class Readers extends Model
{
    public $id;
    public $name;
    public $birth_date;
    public $phone;
    
    protected $table = 'readers';
    protected $primaryKey = 'id';

    public function __construct($data = [])
    {
        parent::__construct();
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->birth_date = $data['birth_date'] ?? '';
        $this->phone = $data['phone'] ?? '';
    }

    public function getAllReaders()
    {
        try {
            $query = "SELECT * FROM readers";
            $data = $this->select($query);
            return [
                'status' => true,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy danh sách độc giả: ' . $e->getMessage()
            ];
        }
    }

    public function getReaderById($id)
    {
        try {
            $query = "SELECT id, name, birthday AS birth_date, phone FROM readers WHERE id = ?";
            $data = $this->select($query, [$id], true);
            if ($data) {
                return [
                    'status' => true,
                    'message' => 'Lấy độc giả thành công',
                    'data' => $data
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy độc giả'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy độc giả: ' . $e->getMessage()
            ];
        }
    }

    public function createReader($data)
    {
        try {
            $query = "INSERT INTO readers (name, phone, borrowcount) VALUES (?, ?, 0)";
            $result = $this->insert($query, [
                $data['name'],
                $data['phone']
            ]);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Thêm độc giả thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Thêm độc giả thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi thêm độc giả: ' . $e->getMessage()
            ];
        }
    }

    public function updateReader($id, $data)
    {
        try {
            $query = "UPDATE readers SET name = ?, birthday = ?, phone = ? WHERE id = ?";
            $result = $this->update($query, [
                $data['name'],
                $data['birth_date'],
                $data['phone'],
                $id
            ]);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Cập nhật độc giả thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Cập nhật độc giả thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi cập nhật độc giả: ' . $e->getMessage()
            ];
        }
    }

    public function deleteReader($id)
    {
        try {
            $query = "DELETE FROM readers WHERE id = ?";
            $result = $this->delete($query, [$id]);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Xóa độc giả thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Xóa độc giả thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi xóa độc giả: ' . $e->getMessage()
            ];
        }
    }

    public function getReaderByPhone($phone)
    {
        try {
            $query = "SELECT id, name, phone FROM readers WHERE phone = ? LIMIT 1";
            $data = $this->select($query, [$phone], true);
            if ($data) {
                return [
                    'status' => true,
                    'data' => $data
                ];
            } else {
                return [
                    'status' => false,
                    'data' => null
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy độc giả: ' . $e->getMessage()
            ];
        }
    }

}
