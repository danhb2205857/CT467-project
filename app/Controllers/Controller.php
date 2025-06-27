<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;

abstract class Controller extends Controller
{
    protected $requireAuth = true;
    
    public function __construct()
    {
        if ($this->requireAuth) {
            $this->checkAuthentication();
        }
    }

    protected function checkAuthentication()
    {
        Session::checkSession('admin');
    }
    

    // protected function checkPermission($permission = null)
    // {
    //     // Có thể mở rộng để kiểm tra quyền cụ thể
    //     $this->checkAuthentication();
        
    //     // Thêm logic kiểm tra quyền nếu cần
    //     if ($permission) {
    //         // Logic kiểm tra quyền cụ thể
    //     }
    // }

    protected function getCurrentAdmin()
    {
        return [
            'id' => Session::get('adminId'),
            'name' => Session::get('adminName'),
            'email' => Session::get('adminEmail'),
            'avatar' => Session::get('adminAvatar')
        ];
    }

    protected function adminView($view, $data = [])
    {
        $data['currentAdmin'] = $this->getCurrentAdmin();
        $this->view("admin/{$view}", $data);
    }
}