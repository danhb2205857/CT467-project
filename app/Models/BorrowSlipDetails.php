<?php
namespace App\Models;

use App\Core\Model;

class BorrowSlipDetails extends Model
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

    public function getDetailsByBorrowSlipId($borrow_slip_id)
    {
        $query = 'SELECT bsd.*, b.title as book_title, bsd.return_date as returned, bsd.due_date as return_date
                  FROM borrow_slip_details bsd
                  LEFT JOIN books b ON bsd.book_id = b.id
                  WHERE bsd.borrow_slip_id = :borrow_slip_id';
        return $this->select($query, ['borrow_slip_id' => $borrow_slip_id]);
    }
}
