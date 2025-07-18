<?php
namespace App\Models;

use App\Core\Model;

class Books extends Model
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
            $query = 'SELECT b.*, a.name as author_name, c.name as category_name FROM books b
                    LEFT JOIN authors a ON b.author_id = a.id
                    LEFT JOIN categories c ON b.category_id = c.id';
            $data = $this->select($query);
            return [
                'status' => true,
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
            $query = 'SELECT b.*, a.name as author_name, c.name as category_name FROM books b
                    LEFT JOIN authors a ON b.author_id = a.id
                    LEFT JOIN categories c ON b.category_id = c.id
                    WHERE b.id = :id LIMIT 1';
            $data = $this->select($query, ['id' => $id], true);
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
            $query = 'INSERT INTO books (title, author_id, category_id, publish_year, publisher, quantity) VALUES (:title, :author_id, :category_id, :publish_year, :publisher, :quantity)';
            $params = [
                'title' => $data['title'],
                'author_id' => $data['author_id'],
                'category_id' => $data['category_id'],
                'publish_year' => $data['publish_year'],
                'publisher' => $data['publisher'],
                'quantity' => $data['quantity']
            ];
            $result = $this->insert($query, $params);
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
            $query = 'UPDATE books SET title = :title, author_id = :author_id, category_id = :category_id, publish_year = :publish_year, publisher = :publisher, quantity = :quantity WHERE id = :id';
            $params = [
                'id' => $id,
                'title' => $data['title'],
                'author_id' => $data['author_id'],
                'category_id' => $data['category_id'],
                'publish_year' => $data['publish_year'],
                'publisher' => $data['publisher'],
                'quantity' => $data['quantity']
            ];
            $result = $this->update($query, $params);
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
            $query = 'DELETE FROM books WHERE id = :id';
            $result = $this->delete($query, ['id' => $id]);
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

    public function getFilteredBooks($filters = [])
    {
        try {
            $where = [];
            $params = [];
            if (!empty($filters['title'])) {
                $where[] = 'b.title LIKE :title';
                $params['title'] = '%' . $filters['title'] . '%';
            }
            if (!empty($filters['author'])) {
                $where[] = 'a.name LIKE :author';
                $params['author'] = '%' . $filters['author'] . '%';
            }
            if (!empty($filters['author_id'])) {
                $where[] = 'b.author_id = :author_id';
                $params['author_id'] = $filters['author_id'];
            }
            if (!empty($filters['category'])) {
                $where[] = 'c.name LIKE :category';
                $params['category'] = '%' . $filters['category'] . '%';
            }
            if (!empty($filters['publisher'])) {
                $where[] = 'b.publisher LIKE :publisher';
                $params['publisher'] = '%' . $filters['publisher'] . '%';
            }
            if (!empty($filters['publish_year'])) {
                $where[] = 'b.publish_year = :publish_year';
                $params['publish_year'] = $filters['publish_year'];
            }
            $query = 'SELECT b.*, a.name as author_name, c.name as category_name 
                    FROM books b
                    LEFT JOIN authors a ON b.author_id = a.id
                    LEFT JOIN categories c ON b.category_id = c.id';
            if ($where) {
                $query .= ' WHERE ' . implode(' AND ', $where);
            }
            $data = $this->select($query, $params);
            return [
                'status' => true,
                'data' => $data
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Lỗi khi lọc sách: ' . $e->getMessage()
            ];
        }
    }
}
