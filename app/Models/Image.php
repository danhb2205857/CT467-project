<?php
namespace App\Models;

class Image
{
    public function __construct(){

    }

    public function upload_image($file, $dir)
    {
        $upload_dir = __DIR__. '../../../public/uploads/'.$dir;
        
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowed_types)) {
            return [
                'status' => 'error',
                'message' => 'Invalid file type. Only JPG, PNG, GIF are allowed.',
                'alert_class' => 'alert-danger',
                'icon' => 'bi-exclamation-triangle-fill'
            ];
        }

        if ($file['size'] > $max_size) {
            return [
                'status' => 'error',
                'message' => 'File size too large. Maximum 5MB allowed.',
                'alert_class' => 'alert-danger',
                'icon' => 'bi-exclamation-triangle-fill'
            ];
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        $filepath = rtrim($upload_dir, '/') . '/' . $filename;

        
        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            $relative_path = $dir . '/' . $filename;
            return [
                'status' => 'success',
                'path' => $relative_path
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Error uploading image.',
                'alert_class' => 'alert-danger',
                'icon' => 'bi-exclamation-triangle-fill'
            ];
        }
    }
}