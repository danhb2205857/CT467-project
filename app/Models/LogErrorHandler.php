<?php
namespace App\Models;

use App\Core\Model;

class LogErrorHandler extends Model
{
    public function handleLogError($exception, $context = [])
    {
        $data = [
            'error' => $exception->getMessage(),
            'context' => $context,
            'time' => date('Y-m-d H:i:s')
        ];
        $this->writeToBackupLog($data);
    }

    public function writeToBackupLog($data)
    {
        $logFile = __DIR__ . '/../../storage/logs/backup_log.log';
        file_put_contents($logFile, json_encode($data) . PHP_EOL, FILE_APPEND);
    }

    public function retryFailedLogs()
    {
        // ??c file backup_log.log v? th? ghi l?i v?o DB n?u c?n
    }

    private function isLogTableAvailable()
    {
        $result = $this->select('SHOW TABLES LIKE "admin_logs"');
        return !empty($result);
    }
}
