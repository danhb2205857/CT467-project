<?php
namespace App\Services;

use PDO;
use App\Core\Database;

class LogService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Ghi log ho?t ??ng chung
     */
    public function logAction($adminId, $actionType, $data = [])
    {
        $ip = $this->getClientIp();
        $userAgent = $this->getUserAgent();
        $sql = "INSERT INTO admin_logs (admin_id, action_type, table_name, record_id, old_data, new_data, ip_address, user_agent, error_message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $adminId,
            $actionType,
            $data['table_name'] ?? null,
            $data['record_id'] ?? null,
            isset($data['old_data']) ? json_encode($data['old_data']) : null,
            isset($data['new_data']) ? json_encode($data['new_data']) : null,
            $ip,
            $userAgent,
            $data['error_message'] ?? null
        ];
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Ghi log CRUD
     */
    public function logCRUD($adminId, $actionType, $tableName, $recordId, $oldData, $newData)
    {
        return $this->logAction($adminId, $actionType, [
            'table_name' => $tableName,
            'record_id' => $recordId,
            'old_data' => $oldData,
            'new_data' => $newData
        ]);
    }

    /**
     * Ghi log l?i h? th?ng
     */
    public function logError($adminId, $errorMessage, $context = [])
    {
        return $this->logAction($adminId, 'ERROR', [
            'error_message' => $errorMessage,
            'table_name' => $context['table_name'] ?? null,
            'record_id' => $context['record_id'] ?? null,
            'old_data' => $context['old_data'] ?? null,
            'new_data' => $context['new_data'] ?? null
        ]);
    }

    /**
     * L?y IP client
     */
    private function getClientIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        }
    }

    /**
     * L?y User Agent
     */
    private function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    }
}
