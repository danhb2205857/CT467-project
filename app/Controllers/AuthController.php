<?php
namespace App\Controllers;

use App\Core\Session;
use App\Core\Controller;
use App\Models\Admin;


class AuthController extends Controller
{

    public function index()
    {
        Session::checkSession('admin');
        $this->view('book/index');
    }

    public function showLogin()
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        $this->view('auth/login');
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['adminEmail'] ?? '';
            $password = $_POST['adminPass'] ?? '';

            if (empty($email) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ thông tin";
                $this->view('auth/login', ['error' => $error]);
                return;
            }

            $admin = new Admin();
            $loginResult = $admin->login_admin($email, $password);

            if ($loginResult['status'] === true) {
                Session::set('admin', true);
                Session::set("adminId", $loginResult['data']['id']);
                Session::set("adminAvatar", $loginResult['data']['avatar']);
                Session::set("adminEmail", $loginResult['data']['email']);
                Session::set("adminName", $loginResult['data']['name']);
                $this->redirect('/dashboard');
            } else {
                $error = "Email hoặc mật khẩu không đúng";
                $this->view('auth/login', ['error' => $error]);
            }
        } else {
            $this->redirect('/auth/login');
        }
    }

    public function logout()
    {
        Session::destroy();
        $this->redirect('/auth/login');
    }
}
