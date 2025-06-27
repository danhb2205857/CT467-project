<?php
namespace App\Models;

use App\Core\Model;

class Reader extends Model
{
    public $id;
    public $name;
    public $birthday;
    public $phone;
    
    protected $table = 'readers';
    protected $primaryKey = 'id';

    public function __construct($data = [])
    {
        parent::__construct();
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->birthday = $data['birthday'] ?? '';
        $this->phone = $data['phone'] ?? '';
    }

    public function getAllReaders()
    {
        try {
            $data = $this->getAll();
            return [
                'status' => true,
                'message' => 'Lấy danh sách độc giả thành công',
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
            $data = $this->getById($id);
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
            $result = $this->create($data);
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
            $result = $this->updateById($id, $data);
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
            $result = $this->deleteById($id);
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
}
