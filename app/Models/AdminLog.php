<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class AdminLog extends Model
{
    protected $table = 'admin_logs';
    protected $primaryKey = 'id';

    public function __construct($data = [])
    {
        parent::__construct();
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * T?o log entry m?i
     */
    public function createLog($data)
    {
        $sql = "INSERT INTO admin_logs (admin_id, action_type, table_name, record_id, old_data, new_data, ip_address, user_agent, error_message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $data['admin_id'],
            $data['action_type'],
            $data['table_name'] ?? null,
            $data['record_id'] ?? null,
            isset($data['old_data']) ? json_encode($data['old_data']) : null,
            isset($data['new_data']) ? json_encode($data['new_data']) : null,
            $data['ip_address'] ?? null,
            $data['user_agent'] ?? null,
            $data['error_message'] ?? null
        ];
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * L?y log theo admin c? th?
     */
    public function getLogsByAdmin($adminId, $filters = [])
    {
        $sql = "SELECT * FROM admin_logs WHERE admin_id = ?";
        $params = [$adminId];
        if (!empty($filters['action_type'])) {
            $sql .= " AND action_type = ?";
            $params[] = $filters['action_type'];
        }
        if (!empty($filters['date_from'])) {
            $sql .= " AND created_at >= ?";
            $params[] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $sql .= " AND created_at <= ?";
            $params[] = $filters['date_to'];
        }
        $sql .= " ORDER BY created_at DESC";
        return $this->select($sql, $params);
    }

    /**
     * L?c log theo kho?ng th?i gian
     */
    public function getLogsByDateRange($startDate, $endDate, $filters = [])
    {
        $sql = "SELECT * FROM admin_logs WHERE created_at BETWEEN ? AND ?";
        $params = [$startDate, $endDate];
        if (!empty($filters['admin_id'])) {
            $sql .= " AND admin_id = ?";
            $params[] = $filters['admin_id'];
        }
        if (!empty($filters['action_type'])) {
            $sql .= " AND action_type = ?";
            $params[] = $filters['action_type'];
        }
        $sql .= " ORDER BY created_at DESC";
        return $this->select($sql, $params);
    }

    /**
     * L?c log theo lo?i ho?t ??ng
     */
    public function getLogsByActionType($actionType, $filters = [])
    {
        $sql = "SELECT * FROM admin_logs WHERE action_type = ?";
        $params = [$actionType];
        if (!empty($filters['admin_id'])) {
            $sql .= " AND admin_id = ?";
            $params[] = $filters['admin_id'];
        }
        if (!empty($filters['date_from'])) {
            $sql .= " AND created_at >= ?";
            $params[] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $sql .= " AND created_at <= ?";
            $params[] = $filters['date_to'];
        }
        $sql .= " ORDER BY created_at DESC";
        return $this->select($sql, $params);
    }

    /**
     * T?m ki?m log theo t? kh?a
     */
    public function searchLogs($keyword, $filters = [])
    {
        $sql = "SELECT * FROM admin_logs WHERE (user_agent LIKE ? OR error_message LIKE ? OR table_name LIKE ?)";
        $params = ["%$keyword%", "%$keyword%", "%$keyword%"];
        if (!empty($filters['admin_id'])) {
            $sql .= " AND admin_id = ?";
            $params[] = $filters['admin_id'];
        }
        if (!empty($filters['action_type'])) {
            $sql .= " AND action_type = ?";
            $params[] = $filters['action_type'];
        }
        if (!empty($filters['date_from'])) {
            $sql .= " AND created_at >= ?";
            $params[] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $sql .= " AND created_at <= ?";
            $params[] = $filters['date_to'];
        }
        $sql .= " ORDER BY created_at DESC";
        return $this->select($sql, $params);
    }
}
