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
    // Thêm các phương thức CRUD ở đây
}
