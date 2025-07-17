<?php
namespace App\Models;

use App\Core\Model;

class AdminLogCache extends Model
{
    protected $table = 'admin_logs';

    public function getCachedStatistics()
    {
        $cacheFile = __DIR__ . '/../../storage/logs/statistics_cache.json';
        if (file_exists($cacheFile) && filemtime($cacheFile) > time() - 300) {
            return json_decode(file_get_contents($cacheFile), true);
        }
        $stats = $this->select("SELECT action_type, COUNT(*) as count FROM admin_logs GROUP BY action_type");
        file_put_contents($cacheFile, json_encode($stats));
        return $stats;
    }

    public function getPaginatedLogs($page = 1, $limit = 20)
    {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM admin_logs ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
        return $this->select($sql);
    }
}
