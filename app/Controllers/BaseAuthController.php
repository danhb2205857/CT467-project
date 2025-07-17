<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Session;
use App\Services\LogService;

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

    protected function logCrudAction($actionType, $tableName, $recordId = null, $oldData = null, $newData = null)
    {
        $admin = $this->getCurrentAdmin();
        if ($admin['id']) {
            $logService = new LogService();
            $logService->logCRUD($admin['id'], $actionType, $tableName, $recordId, $oldData, $newData);
        }
    }
}