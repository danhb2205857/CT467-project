<?php
namespace App\Services;

use App\Core\Database;
use PDO;

class SessionService
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * T?o phi?n ??ng nh?p m?i
     */
    public function createSession($adminId, $sessionToken, $ipAddress, $userAgent)
    {
        $sql = "INSERT INTO admin_sessions (admin_id, session_token, login_time, ip_address, user_agent, is_active, last_activity) VALUES (?, ?, NOW(), ?, ?, 1, NOW())";
        $params = [$adminId, $sessionToken, $ipAddress, $userAgent];
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Ki?m tra t?nh h?p l? c?a phi?n
     */
    public function validateSession($sessionToken)
    {
        $sql = "SELECT * FROM admin_sessions WHERE session_token = ? AND is_active = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$sessionToken]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * K?t th?c phi?n ??ng nh?p
     */
    public function endSession($sessionToken)
    {
        $sql = "UPDATE admin_sessions SET is_active = 0, logout_time = NOW() WHERE session_token = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$sessionToken]);
    }

    /**
     * Ph?t hi?n ho?t ??ng b?t th??ng (v? d?: ??ng nh?p t? nhi?u IP, nhi?u thi?t b?)
     */
    public function detectSuspiciousActivity($adminId)
    {
        $sql = "SELECT ip_address, COUNT(*) as count FROM admin_sessions WHERE admin_id = ? GROUP BY ip_address HAVING count > 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$adminId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * L?y c?c phi?n ?ang ho?t ??ng c?a admin
     */
    public function getActiveSessions($adminId)
    {
        $sql = "SELECT * FROM admin_sessions WHERE admin_id = ? AND is_active = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$adminId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
