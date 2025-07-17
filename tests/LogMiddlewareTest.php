<?php
use PHPUnit\Framework\TestCase;
use App\Middleware\LogMiddleware;

class LogMiddlewareTest extends TestCase
{
    public function testShouldLog()
    {
        $middleware = new LogMiddleware();
        $request = [];
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertTrue($this->invokeMethod($middleware, 'shouldLog', [$request]));
    }

    protected function invokeMethod(&$object, $methodName, array $parameters = array()) {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
}
