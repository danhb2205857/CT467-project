<?php
namespace App\Controllers;

use App\Core\Session;
use App\Core\Controller;
use App\Models\Admin;
use App\Services\LogService;
use App\Services\SessionService;


class AuthController extends Controller
{

    public function index()
    {
        Session::checkSession('admin');
        $this->view('dashboard');
    }

    public function showLogin()
    {
        if (Session::isLoggedIn()) {
            $this->redirect('/');
        }
        $this->view('auth/login', [], false);
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = "Vui lòng nhập đầy đủ thông tin";
                $this->view('auth/login', ['error' => $error], false);
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
                // Ghi log đăng nhập
                $logService = new LogService();
                $logService->logAction($loginResult['data']['id'], 'LOGIN', ['table_name' => 'admins']);
                // Tạo session
                $sessionService = new SessionService();
                $sessionToken = session_id();
                $sessionService->createSession($loginResult['data']['id'], $sessionToken, $_SERVER['REMOTE_ADDR'] ?? '', $_SERVER['HTTP_USER_AGENT'] ?? '');
                $this->redirect('/');
            } else {
                $error = "Email hoặc mật khẩu không đúng";
                $this->view('auth/login', ['error' => $error], false);
            }
        } else {
            $this->redirect('/login');
        }
    }

    public function logout()
    {
        // Ghi log đăng xuất
        $adminId = Session::get('adminId');
        if ($adminId) {
            $logService = new LogService();
            $logService->logAction($adminId, 'LOGOUT', ['table_name' => 'admins']);
            // Kết thúc session
            $sessionService = new SessionService();
            $sessionToken = session_id();
            $sessionService->endSession($sessionToken);
        }
        Session::destroy();
        $this->redirect('/login');
    }
}
