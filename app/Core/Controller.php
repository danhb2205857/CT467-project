<?php

namespace App\Core;

abstract class Controller
{
    protected function view($view, $data = [], $useLayout = true)
    {
        extract($data);

        $viewPath = __DIR__ . "/../Views/{$view}.php";

        if (!file_exists($viewPath)) {
            throw new \Exception("View {$view} not found");
        }
        
        require $viewPath;
    }

    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    protected function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
