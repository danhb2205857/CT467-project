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
}
