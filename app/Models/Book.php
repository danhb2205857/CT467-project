<?php
namespace App\Models;

use App\Core\Model;

class Book extends Model
{
    public $id;
    public $author_id;
    public $category_id;
    public $title;
    public $publish_year;
    public $publisher;
    public $quantity;
    
    protected $table = 'books';
    protected $primaryKey = 'id';

    public function __construct($data = [])
    {
        parent::__construct();
        $this->id = $data['id'] ?? null;
        $this->author_id = $data['author_id'] ?? null;
        $this->category_id = $data['category_id'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->publish_year = $data['publish_year'] ?? '';
        $this->publisher = $data['publisher'] ?? '';
        $this->quantity = $data['quantity'] ?? 0;
    }

    public function getAllBooks()
    {
        try {
            $sql = 'SELECT b.*, a.name as author_name, c.name as category_name FROM books b
                    LEFT JOIN authors a ON b.author_id = a.id
                    LEFT JOIN categories c ON b.category_id = c.id';
            $data = $this->select($sql);
            return [
                'status' => true,
                'message' => 'Lấy danh sách sách thành công',
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy danh sách sách: ' . $e->getMessage()
            ];
        }
    }

    public function getBookById($id)
    {
        try {
            $data = $this->getById($id);
            if ($data) {
                return [
                    'status' => true,
                    'message' => 'Lấy sách thành công',
                    'data' => $data
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy sách'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lấy sách: ' . $e->getMessage()
            ];
        }
    }

    public function createBook($data)
    {
        try {
            $result = $this->create($data);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Thêm sách thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Thêm sách thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi thêm sách: ' . $e->getMessage()
            ];
        }
    }

    public function updateBook($id, $data)
    {
        try {
            $result = $this->updateById($id, $data);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Cập nhật sách thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Cập nhật sách thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi cập nhật sách: ' . $e->getMessage()
            ];
        }
    }

    public function deleteBook($id)
    {
        try {
            $result = $this->deleteById($id);
            if ($result) {
                return [
                    'status' => true,
                    'message' => 'Xóa sách thành công'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Xóa sách thất bại'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi xóa sách: ' . $e->getMessage()
            ];
        }
    }
    // Thêm các phương thức CRUD ở đây
}
