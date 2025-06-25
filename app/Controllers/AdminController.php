<?php
namespace App\Controllers;

use App\Core\Session;
use App\Models\Admin;

class AdminController extends BaseAdminController
{
    protected $requireAuth = false;
    
    public function __construct()
    {

    }

    public function index()
    {
        Session::checkSession('admin');
        $this->adminView('index');
    }

    public function showLogin()
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/admin');
        }
        $this->view('admin/login');
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['adminEmail'] ?? '';
            $password = $_POST['adminPass'] ?? '';

            if (empty($email) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ thông tin";
                $this->view('admin/login', ['error' => $error]);
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
                $this->redirect('/admin');
            } else {
                $error = "Email hoặc mật khẩu không đúng";
                $this->view('admin/login', ['error' => $error]);
            }
        } else {
            $this->redirect('/admin/login');
        }
    }

    public function logout()
    {
        Session::destroy();
        $this->redirect('/admin/login');
    }
}
