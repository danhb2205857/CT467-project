<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Reader;

class ReaderController extends Controller
{
    public function index()
    {
        $result = (new \App\Models\Reader())->getAllReaders();
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
            $result = (new \App\Models\Reader())->createReader($data);
            $this->view('reader/add', [
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        } else {
            $this->view('reader/add');
        }
    }
    public function edit($id) {
        $result = (new Reader())->getReaderById($id);
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
            $result = (new \App\Models\Reader())->updateReader($id, $data);
            $reader = (new \App\Models\Reader())->getReaderById($id);
            $this->view('reader/edit', [
                'reader' => $reader['data'] ?? null,
                'message' => $result['message'],
                'status' => $result['status']
            ]);
        }
    }
    public function delete($id) {
        $result = (new \App\Models\Reader())->deleteReader($id);
        $readers = (new \App\Models\Reader())->getAllReaders();
        $this->view('reader/index', [
            'readers' => $readers['data'] ?? [],
            'message' => $result['message'],
            'status' => $result['status']
        ]);
    }
}
