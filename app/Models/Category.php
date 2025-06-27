<?php
namespace App\Models;

use App\Core\Model;

class Category extends Model
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
}
