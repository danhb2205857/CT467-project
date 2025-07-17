<?php
namespace App\Middleware;

use App\Services\LogService;

class LogMiddleware
{
    protected $logService;

    public function __construct()
    {
        $this->logService = new LogService();
    }

    public function handle($request, $next)
    {
        if ($this->shouldLog($request)) {
            $data = $this->extractDataFromRequest($request);
            $adminId = $_SESSION['adminId'] ?? null;
            if ($adminId) {
                $this->logService->logAction($adminId, $data['action_type'], $data);
            }
        }
        return $next($request);
    }


    private function shouldLog($request)
    {

        $method = $_SERVER['REQUEST_METHOD'] ?? '';
        if (in_array($method, ['POST', 'PUT', 'DELETE'])) {
            return true;
        }
        return false;
    }


    private function extractDataFromRequest($request)
    {
        $route = $_SERVER['REQUEST_URI'] ?? '';
        $actionType = $this->detectActionType($route);
        return [
            'action_type' => $actionType,
            'table_name' => $this->detectTableName($route),
            'record_id' => $_POST['id'] ?? null,
            'old_data' => null, // C? th? b? sung l?y d? li?u c? n?u c?n
            'new_data' => $_POST ?? null,
            'error_message' => null
        ];
    }


    private function detectActionType($route)
    {
        if (stripos($route, 'login') !== false) return 'LOGIN';
        if (stripos($route, 'logout') !== false) return 'LOGOUT';
        if (stripos($route, 'add') !== false) return 'CREATE';
        if (stripos($route, 'edit') !== false) return 'UPDATE';
        if (stripos($route, 'delete') !== false) return 'DELETE';
        return 'READ';
    }


    private function detectTableName($route)
    {

        $parts = explode('/', trim($route, '/'));
        return $parts[0] ?? null;
    }
}
