<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\AdminLog;

class AdminLogsController extends Controller
{
    private $adminLog;

    public function __construct()
    {
        $this->adminLog = new AdminLog();
    }

    // Hiển thị danh sách log với phân trang
    public function index()
    {
        $page = $_GET['page'] ?? 1;
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $logs = $this->adminLog->select("SELECT * FROM admin_logs ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
        $this->view('adminlogs/index', ['logs' => $logs]);
    }

    // Xem chi tiết một log entry
    public function show($id)
    {
        $log = $this->adminLog->select("SELECT * FROM admin_logs WHERE id = ?", [$id], true);
        
        // Nếu là AJAX request, trả về nội dung không có layout
        if (isset($_GET['ajax'])) {
            echo '<div class="card">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>ID:</b> ' . $log['id'] . '</li>
                        <li class="list-group-item"><b>Admin ID:</b> ' . $log['admin_id'] . '</li>
                        <li class="list-group-item"><b>Action Type:</b> ' . $log['action_type'] . '</li>
                        <li class="list-group-item"><b>Table:</b> ' . $log['table_name'] . '</li>
                        <li class="list-group-item"><b>Record ID:</b> ' . $log['record_id'] . '</li>
                        <li class="list-group-item"><b>IP:</b> ' . $log['ip_address'] . '</li>
                        <li class="list-group-item"><b>User Agent:</b> ' . htmlspecialchars($log['user_agent']) . '</li>
                        <li class="list-group-item"><b>Error:</b> ' . htmlspecialchars($log['error_message'] ?? '') . '</li>
                        <li class="list-group-item"><b>Thời gian:</b> ' . $log['created_at'] . '</li>
                        <li class="list-group-item"><b>Dữ liệu cũ:</b> <pre>' . htmlspecialchars($log['old_data'] ?? '') . '</pre></li>
                        <li class="list-group-item"><b>Dữ liệu mới:</b> <pre>' . htmlspecialchars($log['new_data'] ?? '') . '</pre></li>
                    </ul>
                </div>
            </div>';
            exit;
        }
        
        // Nếu không phải AJAX, redirect về trang chính
        $this->redirect('/adminlogs');
    }

    // Xử lý các bộ lọc log
    public function filter()
    {
        $filters = [
            'admin_id' => $_GET['admin_id'] ?? null,
            'action_type' => $_GET['action_type'] ?? null,
            'date_from' => $_GET['date_from'] ?? null,
            'date_to' => $_GET['date_to'] ?? null
        ];
        
        // Xây dựng query dựa trên filter
        $query = "SELECT * FROM admin_logs WHERE 1=1";
        $params = [];
        
        if (!empty($filters['admin_id'])) {
            $query .= " AND admin_id = ?";
            $params[] = $filters['admin_id'];
        }
        
        if (!empty($filters['action_type'])) {
            $query .= " AND action_type = ?";
            $params[] = $filters['action_type'];
        }
        
        if (!empty($filters['date_from'])) {
            $query .= " AND DATE(created_at) >= ?";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $query .= " AND DATE(created_at) <= ?";
            $params[] = $filters['date_to'];
        }
        
        $query .= " ORDER BY created_at DESC";
        
        $logs = $this->adminLog->select($query, $params);
        $this->view('adminlogs/index', ['logs' => $logs]);
    }

    // Hiển thị thống kê hoạt động
    public function statistics()
    {
        $stats = $this->adminLog->select("SELECT action_type, COUNT(*) as count FROM admin_logs GROUP BY action_type");
        
        // Nếu là AJAX request, trả về nội dung không có layout
        if (isset($_GET['ajax'])) {
            echo '<table class="table table-bordered table-hover">
                <thead class="table-warning">
                    <tr>
                        <th>Loại hành động</th>
                        <th>Số lượng</th>
                    </tr>
                </thead>
                <tbody>';
            
            foreach ($stats as $row) {
                echo '<tr>
                    <td>' . $row['action_type'] . '</td>
                    <td>' . $row['count'] . '</td>
                </tr>';
            }
            
            echo '</tbody>
            </table>';
            exit;
        }
        
        // Nếu không phải AJAX, redirect về trang chính
        $this->redirect('/adminlogs');
    }

    // Xuất log ra file CSV
    public function export()
    {
        $logs = $this->adminLog->select("SELECT * FROM admin_logs");
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=admin_logs.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, array_keys($logs[0] ?? []));
        foreach ($logs as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
    }
}