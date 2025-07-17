<?php
namespace App\Models;

use App\Core\Model;

class AdminLogArchive extends Model
{
    protected $table = 'admin_logs';

    public function archiveOldLogs($olderThan = '1 year')
    {
        $date = date('Y-m-d H:i:s', strtotime("-{$olderThan}"));
        $sql = "SELECT * FROM admin_logs WHERE created_at < ?";
        $oldLogs = $this->select($sql, [$date]);
        if ($oldLogs) {
            $archiveFile = __DIR__ . '/../../storage/logs/admin_logs_archive_' . date('Ymd_His') . '.json';
            file_put_contents($archiveFile, json_encode($oldLogs));
            $this->deleteOldLogs($date);
        }
    }

    public function deleteOldLogs($date)
    {
        $sql = "DELETE FROM admin_logs WHERE created_at < ?";
        $this->delete($sql, [$date]);
    }

    public function exportLogsToCSV()
    {
        $logs = $this->select("SELECT * FROM admin_logs");
        $csvFile = __DIR__ . '/../../storage/logs/admin_logs_export_' . date('Ymd_His') . '.csv';
        $fp = fopen($csvFile, 'w');
        if (!empty($logs)) {
            fputcsv($fp, array_keys($logs[0]));
            foreach ($logs as $row) {
                fputcsv($fp, $row);
            }
        }
        fclose($fp);
    }
}
