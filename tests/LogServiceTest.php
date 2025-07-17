<?php
use PHPUnit\Framework\TestCase;
use App\Services\LogService;

class LogServiceTest extends TestCase
{
    public function testLogAction()
    {
        $logService = new LogService();
        $result = $logService->logAction(1, 'LOGIN', ['table_name' => 'admins']);
        $this->assertTrue($result);
    }
}
