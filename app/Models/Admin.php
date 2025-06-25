<?php

namespace App\Models;

use App\Core\Model;

class Admin extends Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function login_admin($adminEmail, $adminPass)
    {
        $adminEmail = $this->fm->validation($adminEmail);
        $adminPass = $this->fm->validation($adminPass);

        if (empty($adminEmail) || empty($adminPass)) {
            return 'Tài khoản hoặc mật khẩu trống';
        }

        $query = "SELECT * FROM users WHERE email = ? AND role = ?";
        $result = $this->select($query, [$adminEmail, $this->index['admin']], true);

        if ($result && $adminPass == $result['password']) {
            $res = [
                'status' => true,
                'data' => $result
            ];
        }
        else
            $res = [
                'status' => false,
                ];
        return $res;
    }
}
