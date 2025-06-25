<?php
namespace App\Core;

class Router
{
    private $routes = [];
    
    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }
    
    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }
    
    public function put($path, $callback)
    {
        $this->routes['PUT'][$path] = $callback;
    }
    
    public function delete($path, $callback)
    {
        $this->routes['DELETE'][$path] = $callback;
    }
    
    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove trailing slash
        $path = rtrim($path, '/');
        if (empty($path)) {
            $path = '/';
        }
        
        if (isset($this->routes[$method][$path])) {
            $callback = $this->routes[$method][$path];
            $this->executeCallback($callback);
        } else {
            // Try to match dynamic routes
            $this->matchDynamicRoute($method, $path);
        }
    }
    
    private function executeCallback($callback)
    {
        if (is_string($callback)) {
            // Format: "ControllerName@methodName"
            [$controller, $method] = explode('@', $callback);
            $controllerClass = "App\\Controllers\\{$controller}";
            
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                if (method_exists($controllerInstance, $method)) {
                    $controllerInstance->$method();
                } else {
                    $this->notFound();
                }
            } else {
                $this->notFound();
            }
        } elseif (is_callable($callback)) {
            call_user_func($callback);
        }
    }
    
    private function matchDynamicRoute($method, $path)
    {
        foreach ($this->routes[$method] ?? [] as $route => $callback) {
            // Convert route pattern to regex
            $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            
            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // Remove full match
                
                if (is_string($callback)) {
                    [$controller, $method] = explode('@', $callback);
                    $controllerClass = "App\\Controllers\\{$controller}";
                    
                    if (class_exists($controllerClass)) {
                        $controllerInstance = new $controllerClass();
                        if (method_exists($controllerInstance, $method)) {
                            call_user_func_array([$controllerInstance, $method], $matches);
                            return;
                        }
                    }
                }
            }
        }
        
        $this->notFound();
    }
    
    private function notFound()
    {
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}
