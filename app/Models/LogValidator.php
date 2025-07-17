<?php
namespace App\Models;

class LogValidator
{
    public function validateLogData($data)
    {
        // Ki?m tra c?c tr??ng b?t bu?c
        return isset($data['admin_id'], $data['action_type']);
    }

    public function sanitizeInput($input)
    {
        return htmlspecialchars(strip_tags($input));
    }

    public function checkPermission($adminId, $action)
    {
        // Ch? super_admin m?i ???c xem t?t c? log
        // Gi? s? c? h?m getRoleByAdminId($adminId)
        $role = $this->getRoleByAdminId($adminId);
        if ($role === 'super_admin') return true;
        if ($action === 'view_own') return true;
        return false;
    }

    private function isValidActionType($actionType)
    {
        $valid = ['LOGIN','LOGOUT','CREATE','READ','UPDATE','DELETE','ERROR'];
        return in_array($actionType, $valid);
    }

    private function getRoleByAdminId($adminId)
    {
        // TODO: L?y role t? b?ng admins
        return 'admin';
    }
}
