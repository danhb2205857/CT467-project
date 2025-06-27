<?php
namespace App\Models;

use App\Core\Model;

class BorrowSlip extends Model
{
    public $id;
    public $reader_id;
    public $borrow_date;
    public $return_date;
    public $status;
    
    protected $table = 'borrow_slips';
    protected $primaryKey = 'id';

    public function __construct($data = [])
    {
        parent::__construct();
        $this->id = $data['id'] ?? null;
        $this->reader_id = $data['reader_id'] ?? null;
        $this->borrow_date = $data['borrow_date'] ?? '';
        $this->return_date = $data['return_date'] ?? '';
        $this->status = $data['status'] ?? '';
    }
}
