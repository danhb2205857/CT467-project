<?php
namespace App\Models;

use App\Core\Model;

class Authors extends Model
{
    public $id;
    public $name;
    
    protected $table = 'authors';
    protected $primaryKey = 'id';

    public function __construct($data = [])
    {
        parent::__construct();
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
    }

    public function getAllAuthors()
    {
        try {
            $query = "SELECT a.*, COUNT(b.id) as total_books FROM authors a LEFT JOIN books b ON a.id = b.author_id GROUP BY a.id ORDER BY a.id";
            $data = $this->select($query);
            return [
                'status' => true,
                'message' => '',
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy danh sách tác giả: ' . $e->getMessage()
            ];
        }
    }

    public function getAuthorById($id)
    {
        try {
            $query = "SELECT * FROM authors WHERE id = ?";
            $data = $this->select($query, [$id], true);
            if ($data) {
                return [
                    'status' => true,
                    'message' => 'Lấy tác giả thành công',
                    'data' => $data
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy tác giả'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy tác giả: ' . $e->getMessage()
            ];
        }
    }

    public function createAuthor($data)
    {
        try {
            $query = "INSERT INTO authors (name) VALUES (?)";
            $result = $this->insert($query, [$data['name']]);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Thêm tác giả thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Thêm tác giả thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi thêm tác giả: ' . $e->getMessage()
            ];
        }
    }

    public function updateAuthor($id, $data)
    {
        try {
            $query = "UPDATE authors SET name = ? WHERE id = ?";
            $result = $this->update($query, [$data['name'], $id]);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Cập nhật tác giả thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Cập nhật tác giả thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi cập nhật tác giả: ' . $e->getMessage()
            ];
        }
    }

    public function deleteAuthor($id)
    {
        try {
            $query = "DELETE FROM authors WHERE id = ?";
            $result = $this->delete($query, [$id]);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Xóa tác giả thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Xóa tác giả thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi xóa tác giả: ' . $e->getMessage()
            ];
        }
    }
}
