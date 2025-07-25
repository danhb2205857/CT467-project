<?php

namespace App\Traits;

use App\Services\ExcelService;

trait ExcelExportTrait
{
    /**
     * Xuất Excel cho module hiện tại
     * 
     * @param string $module - Tên module (borrowslips, books, authors, categories, readers)
     * @param array $data - Dữ liệu cần xuất (optional, nếu không có sẽ lấy tất cả)
     */
    public function exportExcel($module = null, $data = null)
    {
        // Tự động xác định module từ controller name nếu không được truyền vào
        if (!$module) {
            $className = get_class($this);
            $module = $this->getModuleFromController($className);
        }

        // Lấy dữ liệu nếu chưa có
        if (!$data) {
            $data = $this->getDataForExport($module);
        }

        // Xử lý dữ liệu
        $processedData = ExcelService::processData($data, $module);

        // Lấy headers
        $headers = ExcelService::getHeaders($module);

        // Tạo tên file
        $filename = ExcelService::generateFilename($module);

        // Xuất Excel
        ExcelService::export($processedData, $headers, $filename);
    }

    /**
     * Xác định module từ tên controller
     */
    private function getModuleFromController($className)
    {
        $controllerName = strtolower(str_replace(['App\\Controllers\\', 'Controller'], '', $className));

        $mapping = [
            'borrowslips' => 'borrowslips',
            'books' => 'books',
            'authors' => 'authors',
            'categories' => 'categories',
            'readers' => 'readers',
            'dashboard' => 'borrowslips' // Dashboard xuất phiếu mượn
        ];

        return $mapping[$controllerName] ?? 'borrowslips';
    }

    /**
     * Lấy dữ liệu để xuất Excel cho từng module
     */
    private function getDataForExport($module)
    {
        switch ($module) {
            case 'borrowslips':
                $model = new \App\Models\BorrowSlips();
                $result = $model->getAllBorrowSlips();
                return $result['data'] ?? [];

            case 'books':
                $model = new \App\Models\Books();
                $result = $model->getAllBooks();
                return $result['data'] ?? [];

            case 'authors':
                $model = new \App\Models\Authors();
                $result = $model->getAllAuthors();
                return $result['data'] ?? [];

            case 'categories':
                $model = new \App\Models\Categories();
                $result = $model->getAllCategories();
                return $result['data'] ?? [];

            case 'readers':
                $model = new \App\Models\Readers();
                $result = $model->getAllReaders();
                return $result['data'] ?? [];

            default:
                return [];
        }
    }
}
