<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\Readers;
use App\Core\Session;

class ReadersController extends BaseAuthController
{
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
            $result = $this->reader->updateReader($id, $data);
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /readers');
            exit;
        }
    }
    public function delete($id) {
        $result = $this->reader->deleteReader($id);
        Session::flash('message', $result['message']);
        Session::flash('status', $result['status']);
        header('Location: /readers');
        exit;
    }
}
