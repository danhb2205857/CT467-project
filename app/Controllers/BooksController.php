<?php

namespace App\Controllers;

use App\Controllers\BaseAuthController;
use App\Models\Books;
use App\Core\Session;
use App\Traits\ExcelExportTrait;

class BooksController extends BaseAuthController
{
    use ExcelExportTrait;

    private $book;

    public function __construct()
    {
        $this->book = new Books();
    }

    public function index()
    {
        $filters = [
            'title' => $_GET['title'] ?? '',
            'author' => $_GET['author'] ?? '',
            'category' => $_GET['category'] ?? '',
            'publisher' => $_GET['publisher'] ?? '',
            'publish_year' => $_GET['publish_year'] ?? '',
            'author_id' => $_GET['author_id'] ?? '',
            'category_id' => $_GET['category_id'] ?? '',
        ];
        $special_filters = [];
        if (!empty($filters['author_id'])) {
            $authorModel = new \App\Models\Authors();
            $authorData = $authorModel->getAuthorById($filters['author_id']);
            if (!empty($authorData['data'])) {
                $special_filters['author'] = [
                    'id' => $filters['author_id'],
                    'name' => $authorData['data']['name'],
                    'param' => 'author_id'
                ];
            }
        }
        if (!empty($filters['category_id'])) {
            $categoryModel = new \App\Models\Categories();
            $categoryData = $categoryModel->getCategoryById($filters['category_id']);
            if (!empty($categoryData['data'])) {
                $special_filters['category'] = [
                    'id' => $filters['category_id'],
                    'name' => $categoryData['data']['name'],
                    'param' => 'category_id'
                ];
            }
        }
        $hasFilter = false;
        foreach ($filters as $v) {
            if ($v !== '' && $v !== null) {
                $hasFilter = true;
                break;
            }
        }
        if ($hasFilter) {
            $result = $this->book->getFilteredBooks($filters);
        } else {
            $result = $this->book->getAllBooks();
        }
        $authors = (new \App\Models\Authors())->getAllAuthors()['data'] ?? [];
        $categories = (new \App\Models\Categories())->getAllCategories()['data'] ?? [];
        $message = Session::flash('message');
        $status = Session::flash('status');
        $this->view('books/index', [
            'books' => $result['data'] ?? [],
            'authors' => $authors,
            'categories' => $categories,
            'special_filters' => $special_filters,
            'filters' => $filters,
            'message' => $message !== null ? $message : ($result['message'] ?? ''),
            'status' => $status !== null ? $status : ($result['status'] ?? null)
        ]);
    }

    public function insert()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'author_id' => $_POST['author_id'] ?? '',
                'category_id' => $_POST['category_id'] ?? '',
                'publish_year' => $_POST['publish_year'] ?? '',
                'publisher' => $_POST['publisher'] ?? '',
                'quantity' => $_POST['quantity'] ?? 0,
            ];
            $result = $this->book->createBook($data);
            if ($result['status']) {
                $this->logCrudAction('CREATE', 'books', null, null, $data);
            }
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /books');
            exit;
        }
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'author_id' => $_POST['author_id'] ?? '',
                'category_id' => $_POST['category_id'] ?? '',
                'publish_year' => $_POST['publish_year'] ?? '',
                'publisher' => $_POST['publisher'] ?? '',
                'quantity' => $_POST['quantity'] ?? 0,
            ];
            $old = $this->book->getBookById($id)['data'] ?? null;
            $result = $this->book->updateBook($id, $data);
            if ($result['status']) {
                $this->logCrudAction('UPDATE', 'books', $id, $old, $data);
            }
            Session::flash('message', $result['message']);
            Session::flash('status', $result['status']);
            header('Location: /books');
            exit;
        }
    }

    public function delete($id)
    {
        $old = $this->book->getBookById($id)['data'] ?? null;
        $result = $this->book->deleteBook($id);
        if ($result['status']) {
            $this->logCrudAction('DELETE', 'books', $id, $old, null);
        }
        Session::flash('message', $result['message']);
        Session::flash('status', $result['status']);
        header('Location: /books');
        exit;
    }

    public function findById()
    {
        $id = $_GET['id'] ?? '';
        $result = $this->book->getBookById($id);
        header('Content-Type: application/json');
        if ($result && !empty($result['data'])) {
            echo json_encode($result['data']);
        } else {
            echo json_encode([]);
        }
        exit;
    }

    public function checkAvailable()
    {
        $id = $_GET['id'] ?? null;
        $model = new \App\Models\Books();
        $available = $model->checkAvailable($id);
        $this->json(['available' => $available]);
    }

    /**
     * Xuất Excel danh sách sách
     */
    public function exportExcelBooks()
    {
        // Lấy dữ liệu với filter nếu có
        $filters = [
            'title' => $_GET['title'] ?? '',
            'author' => $_GET['author'] ?? '',
            'category' => $_GET['category'] ?? '',
            'publisher' => $_GET['publisher'] ?? '',
            'publish_year' => $_GET['publish_year'] ?? '',
            'author_id' => $_GET['author_id'] ?? '',
            'category_id' => $_GET['category_id'] ?? '',
        ];

        $hasFilter = array_filter($filters);

        if (!empty($hasFilter)) {
            $result = $this->book->getFilteredBooks($filters);
            $data = $result['data'] ?? [];
        } else {
            $result = $this->book->getAllBooks();
            $data = $result['data'] ?? [];
        }

        // Sử dụng trait để xuất Excel
        $this->exportExcel('books', $data);
    }
}
