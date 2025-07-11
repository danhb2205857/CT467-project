<?php

namespace App\Core;

class Session
{
    public static function init()
    {
        if (headers_sent()) {
            return;
        }
        
        if (session_status() === PHP_SESSION_NONE) {
            if (!session_start()) {
                error_log('Không thể khởi tạo session');
                return;
            }
        }
    }

    public static function set($key, $val)
    {
        self::init(); 
        $_SESSION[$key] = $val;
    }

    public static function get($key)
    {
        self::init(); 
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    public static function checkSession($role)
    {
        self::init();
        if($role === 'admin') {
            if (self::get($role) !== true) {
                header("Location: /login");
                exit();
            }
        } else {
        if (self::get($role) !== true) {
            header("Location: /login");
            exit();
        }
    }
    }

    public static function checkLogin($role)
    {
        self::init();
        if($role === "admin") {
            if (self::get($role) === true) {
                header("Location: /");
            }
        } else {
        
           if (self::get($role) === true) {
                header("Location: /");
            }
        }
    }


    public static function isLoggedIn()
    {
        self::init();
        return self::get('admin') === true;
    }
    
    public static function isLoggedIn_user()
    {
        self::init();
        return self::get('user') === true;
    }

    public static function getCurrentUser()
    {
        if (self::isLoggedIn_user()) {
            return [
                'id' => self::get('userId'),
                'name' => self::get('userName'),
                'email' => self::get('userEmail'),
                'avatar' => self::get('userAvatar')
            ];
        }
        return null;
    }

    public static function destroy()
    {
        self::init();
        session_destroy();
    }

    public static function flash($key, $val = null)
    {
        self::init();
        if ($val !== null) {
            $_SESSION[$key] = $val;
            return null;
        } else {
            if (isset($_SESSION[$key])) {
                $tmp = $_SESSION[$key];
                unset($_SESSION[$key]);
                return $tmp;
            }
            return null;
        }
    }
}