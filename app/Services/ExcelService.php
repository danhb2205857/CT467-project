<?php

namespace App\Services;

class ExcelService
{
    /**
     * Xuất dữ liệu ra file Excel (CSV format)
     * 
     * @param array $data - Dữ liệu cần xuất
     * @param array $headers - Tiêu đề các cột
     * @param string $filename - Tên file (không cần extension)
     */
    public static function export($data, $headers, $filename = 'export')
    {
        // Debug: Kiểm tra dữ liệu trước khi xuất
        if (empty($data)) {
            die('Không có dữ liệu để xuất');
        }
        
        // Thiết lập headers cho file CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        
        // Tạo output stream
        $output = fopen('php://output', 'w');
        
        // Thêm BOM để Excel hiển thị đúng tiếng Việt
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Ghi tiêu đề (chỉ lấy values của headers)
        fputcsv($output, array_values($headers), ',', '"', '\\');
        
        // Ghi dữ liệu
        foreach ($data as $row) {
            $csvRow = [];
            foreach (array_keys($headers) as $key) {
                $value = $row[$key] ?? '';
                // Xử lý giá trị null hoặc empty
                $csvRow[] = $value === null ? '' : (string)$value;
            }
            fputcsv($output, $csvRow, ',', '"', '\\');
        }
        
        fclose($output);
        exit;
    }
    
    /**
     * Cấu hình headers cho từng module
     */
    public static function getHeaders($module)
    {
        $configs = [
            'borrowslips' => [
                'phone' => 'Số điện thoại',
                'name' => 'Tên độc giả', 
                'borrow_date' => 'Ngày mượn',
                'due_date' => 'Ngày trả dự kiến',
                'return_date' => 'Ngày trả',
                'status_text' => 'Trạng thái'
            ],
            'books' => [
                'title' => 'Tên sách',
                'author_name' => 'Tác giả',
                'category_name' => 'Thể loại',
                'publish_year' => 'Năm xuất bản',
                'publisher' => 'Nhà xuất bản',
                'quantity' => 'Số lượng',
                'available' => 'Còn lại'
            ],
            'authors' => [
                'stt' => 'STT',
                'name' => 'Tên tác giả',
                'total_books' => 'Tổng số sách'
            ],
            'categories' => [
                'stt' => 'STT',
                'name' => 'Tên thể loại',
                'total_books' => 'Tổng số sách'
            ],
            'readers' => [
                'stt' => 'STT',
                'name' => 'Tên độc giả',
                'phone' => 'Số điện thoại',
                'borrow_count' => 'Số lần đã mượn',
                'book_count' => 'Số sách đã mượn'
            ]
        ];
        
        return $configs[$module] ?? [];
    }
    
    /**
     * Xử lý dữ liệu trước khi xuất
     */
    public static function processData($data, $module)
    {
        switch ($module) {
            case 'borrowslips':
                return array_map(function($item) {
                    $item['status_text'] = self::getStatusText($item['status'] ?? '');
                    $item['return_date'] = $item['return_date'] ?: 'Chưa trả';
                    return $item;
                }, $data);
                
            case 'books':
                return array_map(function($item) {
                    $item['available'] = $item['available'] ?? $item['quantity'] ?? 0;
                    return $item;
                }, $data);
                
            case 'readers':
                return array_map(function($item, $index) {
                    // Thêm STT
                    $item['stt'] = $index + 1;
                    // Đảm bảo các giá trị số không null
                    $item['borrow_count'] = $item['borrow_count'] ?? 0;
                    $item['book_count'] = $item['book_count'] ?? 0;
                    return $item;
                }, $data, array_keys($data));
                
            case 'authors':
                return array_map(function($item, $index) {
                    // Thêm STT
                    $item['stt'] = $index + 1;
                    return $item;
                }, $data, array_keys($data));
                
            case 'categories':
                return array_map(function($item, $index) {
                    // Thêm STT
                    $item['stt'] = $index + 1;
                    return $item;
                }, $data, array_keys($data));
                
            default:
                return $data;
        }
    }
    
    /**
     * Chuyển đổi status code thành text
     */
    private static function getStatusText($status)
    {
        switch ($status) {
            case '0': return 'Đang mượn';
            case '1': return 'Đã trả';
            case '2': return 'Quá hạn';
            default: return 'Không xác định';
        }
    }
    
    /**
     * Tạo tên file với timestamp
     */
    public static function generateFilename($module)
    {
        $names = [
            'borrowslips' => 'danh_sach_phieu_muon',
            'books' => 'danh_sach_sach',
            'authors' => 'danh_sach_tac_gia',
            'categories' => 'danh_sach_the_loai',
            'readers' => 'danh_sach_doc_gia'
        ];
        
        $name = $names[$module] ?? 'export';
        return $name . '_' . date('Y-m-d_H-i-s');
    }
}