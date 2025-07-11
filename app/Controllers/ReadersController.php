<?php
namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\Readers;

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
        $this->view('reader/index', [
            'readers' => $result['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
    public function insertView() {
        $this->view('reader/add');
    }
    public function insert() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'birthday' => $_POST['birthday'] ?? '',
                'phone' => $_POST['phone'] ?? ''
            ];
            $result = $this->reader->createReader($data);
            $this->view('reader/add', [
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        } else {
            $this->view('reader/add');
        }
    }
    public function edit($id) {
        $result = $this->reader->getReaderById($id);
        $this->view('reader/edit', [
            'reader' => $result['data'] ?? null,
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'birthday' => $_POST['birthday'] ?? '',
                'phone' => $_POST['phone'] ?? ''
            ];
            $result = $this->reader->updateReader($id, $data);
            $reader = $this->reader->getReaderById($id);
            $this->view('reader/edit', [
                'reader' => $reader['data'] ?? null,
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        }
    }
    public function delete($id) {
        $result = $this->reader->deleteReader($id);
        $readers = $this->reader->getAllReaders();
        $this->view('reader/index', [
            'readers' => $readers['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
