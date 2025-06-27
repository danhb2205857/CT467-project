<?php
namespace App\Models;

use App\Core\Model;

class BorrowSlipDetail extends Model
{
    public $id;
    public $borrow_slip_id;
    public $book_id;
    public $quantity;
    
    protected $table = 'borrow_slip_details';
    protected $primaryKey = 'id';

    public function __construct($data = [])
    {
        parent::__construct();
        $this->id = $data['id'] ?? null;
        $this->borrow_slip_id = $data['borrow_slip_id'] ?? null;
        $this->book_id = $data['book_id'] ?? null;
        $this->quantity = $data['quantity'] ?? 0;
    }
}
