<?php
use PHPUnit\Framework\TestCase;
use App\Services\SessionService;

class SessionServiceTest extends TestCase
{
    public function testCreateSession()
    {
        $service = new SessionService();
        $result = $service->createSession(1, uniqid(), '127.0.0.1', 'PHPUnit');
        $this->assertTrue($result);
    }
}
