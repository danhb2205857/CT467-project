<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\Categories;
use App\Core\Session;
use App\Traits\ExcelExportTrait;

class CategoriesController extends BaseAuthController
{
    use ExcelExportTrait;
    
    private $category;

    public function __construct()
    {
        $this->category = new Categories();
    }
    public function index()
    {
        $result = $this->category->getAllCategories();
        $message = Session::flash('message');
        $status = Session::flash('status');
        $this->view('categories/index', [
            'categories' => $result['data'] ?? [],
            'message' => $message !== null ? $message : ($result['message'] ?? ''),
            'status' => $status !== null ? $status : ($result['status'] ?? null)
        ]);
    }
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $result = $this->category->createCategory($data);
            if ($result['status']) {
                $this->logCrudAction('CREATE', 'categories', null, null, $data);
            }
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /categories');
            exit;
        }
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $old = $this->category->getCategoryById($id)['data'] ?? null;
            $result = $this->category->updateCategory($id, $data);
            if ($result['status']) {
                $this->logCrudAction('UPDATE', 'categories', $id, $old, $data);
            }
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /categories');
            exit;
        }
    }
    public function delete($id) {
        $old = $this->category->getCategoryById($id)['data'] ?? null;
        $result = $this->category->deleteCategory($id);
        if ($result['status']) {
            $this->logCrudAction('DELETE', 'categories', $id, $old, null);
        }
        Session::flash('message', $result['message']);
        Session::flash('status', $result['status']);
        header('Location: /categories');
        exit;
    }
    

}
