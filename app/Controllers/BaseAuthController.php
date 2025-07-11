<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;

class BaseAuthController extends Controller
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

    protected function getCurrentAdmin()
    {
        return [
            'id' => Session::get('adminId'),
            'name' => Session::get('adminName'),
            'email' => Session::get('adminEmail'),
            'avatar' => Session::get('adminAvatar')
        ];
    }
}