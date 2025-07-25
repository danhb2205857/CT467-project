<?php
namespace App\Controllers;

use App\Core\Session;
use App\Controllers\BaseAuthController;
use App\Models\Dashboard;
use App\Traits\ExcelExportTrait;

class DashboardController extends BaseAuthController
{
    use ExcelExportTrait;
    
    public function index()
    {
        Session::checkSession('admin');
        $dashboard = new Dashboard();
        $data = [
            'totalReaders' => $dashboard->getTotalReaders(),
            'totalCategories' => $dashboard->getTotalCategories(),
            'totalBooks' => $dashboard->getTotalBooks(),
            'totalBorrowedBooks' => $dashboard->getTotalBorrowedBooks(),
            'top10Readers' => $dashboard->getTop10Readers(),
            'top10Books' => $dashboard->getTop10Books(),
        ];
        $this->view('dashboard', $data);
    }
    
    /**
     * Xuất Excel từ Dashboard (xuất danh sách phiếu mượn)
     */
    public function exportExcel()
    {
        $this->exportExcel('borrowslips');
    }
}