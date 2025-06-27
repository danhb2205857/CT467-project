<?php
namespace App\Models;

use App\Core\Model;

class Reader extends Model
{
    public $id;
    public $name;
    public $birthday;
    public $phone;
    
    protected $table = 'readers';
    protected $primaryKey = 'id';

    public function __construct($data = [])
    {
        parent::__construct();
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->birthday = $data['birthday'] ?? '';
        $this->phone = $data['phone'] ?? '';
    }
}
