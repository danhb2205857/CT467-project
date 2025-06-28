<?php
namespace App\Controllers;

use App\Core\Session;
use App\Core\Controller;
use App\Models\Dashboard;

class DashboardController extends Controller
{
    public function index()
    {
        Session::checkSession('admin');
        $dashboard = new Dashboard();
        $data = [
            'totalReaders' => $dashboard->getTotalReaders(),
            'totalCategories' => $dashboard->getTotalCategories(),
            'totalBooks' => $dashboard->getTotalBooks(),
            'totalBorrowedBooks' => $dashboard->getTotalBorrowedBooks(),
        ];
        $this->view('dashboard', $data);
    }
}