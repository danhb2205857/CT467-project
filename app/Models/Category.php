<?php
namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    public $id;
    public $name;
    
    protected $table = 'categories';
    protected $primaryKey = 'id';

    public function __construct($data = [])
    {
        parent::__construct();
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
    }

    public function getAllCategories()
    {
        try {
            $data = $this->getAll();
            return [
                'status' => true,
                'message' => 'Lấy danh sách thể loại thành công',
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy danh sách thể loại: ' . $e->getMessage()
            ];
        }
    }

    public function getCategoryById($id)
    {
        try {
            $data = $this->getById($id);
            if ($data) {
                return [
                    'status' => true,
                    'message' => 'Lấy thể loại thành công',
                    'data' => $data
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy thể loại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy thể loại: ' . $e->getMessage()
            ];
        }
    }

    public function createCategory($data)
    {
        try {
            $result = $this->create($data);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Thêm thể loại thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Thêm thể loại thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi thêm thể loại: ' . $e->getMessage()
            ];
        }
    }

    public function updateCategory($id, $data)
    {
        try {
            $result = $this->updateById($id, $data);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Cập nhật thể loại thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Cập nhật thể loại thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi cập nhật thể loại: ' . $e->getMessage()
            ];
        }
    }

    public function deleteCategory($id)
    {
        try {
            $result = $this->deleteById($id);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Xóa thể loại thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Xóa thể loại thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi xóa thể loại: ' . $e->getMessage()
            ];
        }
    }
}
