<?php
namespace App\Models;

use App\Core\Model;

class AdminLogStatistics extends Model
{
    protected $table = 'admin_logs';

    public function getLogStatistics($period = 'month')
    {
        $groupBy = 'DATE(created_at)';
        if ($period === 'month') $groupBy = 'MONTH(created_at)';
        if ($period === 'year') $groupBy = 'YEAR(created_at)';
        $sql = "SELECT $groupBy as period, action_type, COUNT(*) as count FROM admin_logs GROUP BY period, action_type ORDER BY period DESC";
        return $this->select($sql);
    }

    public function getTopActions($limit = 5)
    {
        $sql = "SELECT action_type, COUNT(*) as count FROM admin_logs GROUP BY action_type ORDER BY count DESC LIMIT ?";
        return $this->select($sql, [$limit]);
    }

    public function detectAbnormalActivities()
    {
        $sql = "SELECT * FROM admin_logs WHERE action_type = 'ERROR' OR error_message IS NOT NULL ORDER BY created_at DESC LIMIT 20";
        return $this->select($sql);
    }
}
