<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\Readers;
use App\Core\Session;
use App\Traits\ExcelExportTrait;

class ReadersController extends BaseAuthController
{
    use ExcelExportTrait;
    
    private $reader;

    public function __construct()
    {
        $this->reader = new Readers();
    }
    public function index()
    {
        $result = $this->reader->getAllReaders();
        $message = Session::flash('message');
        $status = Session::flash('status');
        $this->view('readers/index', [
            'readers' => $result['data'] ?? [],
            'message' => $message !== null ? $message : ($result['message'] ?? ''),
            'status' => $status !== null ? $status : ($result['status'] ?? null)
        ]);
    }
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'birth_date' => $_POST['birth_date'] ?? '',
                'phone' => $_POST['phone'] ?? ''
            ];
            $result = $this->reader->createReader($data);
            if ($result['status']) {
                $this->logCrudAction('CREATE', 'readers', null, null, $data);
            }
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /readers');
            exit;
        }
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'birth_date' => $_POST['birth_date'] ?? '',
                'phone' => $_POST['phone'] ?? ''
            ];
            $old = $this->reader->getReaderById($id)['data'] ?? null;
            $result = $this->reader->updateReader($id, $data);
            if ($result['status']) {
                $this->logCrudAction('UPDATE', 'readers', $id, $old, $data);
            }
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /readers');
            exit;
        }
    }
    public function delete($id) {
        $old = $this->reader->getReaderById($id)['data'] ?? null;
        $result = $this->reader->deleteReader($id);
        if ($result['status']) {
            $this->logCrudAction('DELETE', 'readers', $id, $old, null);
        }
        Session::flash('message', $result['message']);
        Session::flash('status', $result['status']);
        header('Location: /readers');
        exit;
    }
    public function findByPhone()
    {
        $phone = $_GET['phone'] ?? '';
        $result = $this->reader->getReaderByPhone($phone);
        header('Content-Type: application/json');
        if ($result && !empty($result['data'])) {
            echo json_encode(['name' => $result['data']['name']]);
        } else {
            echo json_encode([]);
        }
        exit;
    }
    

}
