<?php
namespace App\Models;

use App\Core\Model;

class Author extends Model
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
            $data = $this->getAll();
            return [
                'status' => true,
                'message' => 'Lấy danh sách tác giả thành công',
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
            $data = $this->getById($id);
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
            $result = $this->create($data);
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
            $result = $this->updateById($id, $data);
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
            $result = $this->deleteById($id);
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
