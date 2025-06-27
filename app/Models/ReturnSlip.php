<?php
namespace App\Models;

use App\Core\Model;

class ReturnSlip extends Model
{
    public $id;
    public $borrow_slip_detail_id;
    public $return_date;
    public $fine;
    
    protected $table = 'return_slips';
    protected $primaryKey = 'id';

    public function __construct($data = [])
    {
        parent::__construct();
        $this->id = $data['id'] ?? null;
        $this->borrow_slip_detail_id = $data['borrow_slip_detail_id'] ?? null;
        $this->return_date = $data['return_date'] ?? '';
        $this->fine = $data['fine'] ?? 0;
    }
}
