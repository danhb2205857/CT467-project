<?php
namespace App\Models;

use App\Core\Model;

class Categories extends Model
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
            $query = "SELECT c.*, COUNT(b.id) as total_books FROM categories c LEFT JOIN books b ON c.id = b.category_id GROUP BY c.id ORDER BY c.id";
            $data = $this->select($query);
            return [
                'status' => true,
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
            $query = "SELECT * FROM categories WHERE id = ?";
            $data = $this->select($query, [$id], true);
            if ($data) {
                return [
                    'status' => true,
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
            $query = "INSERT INTO categories (name) VALUES (?)";
            $result = $this->insert($query, [$data['name']]);
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
            $query = "UPDATE categories SET name = ? WHERE id = ?";
            $result = $this->update($query, [$data['name'], $id]);
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
            $query = "DELETE FROM categories WHERE id = ?";
            $result = $this->delete($query, [$id]);
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
