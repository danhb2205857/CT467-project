<?php

namespace App\Models;

use App\Core\Model;

class Admin extends Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function login_admin($email, $password)
    {
        $email = $this->fm->validation($email);
        $password = $this->fm->validation($password);

        if (empty($email) || empty($password)) {
            return 'Tài khoản hoặc mật khẩu trống';
        }

        $query = "SELECT * FROM admins WHERE email = ?";
        $result = $this->select($query, [$email], true);

        if ($result && $password == $result['password']) {
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
