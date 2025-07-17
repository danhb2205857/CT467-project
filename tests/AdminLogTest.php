<?php
use PHPUnit\Framework\TestCase;
use App\Models\AdminLog;

class AdminLogTest extends TestCase
{
    public function testCreateLog()
    {
        $adminLog = new AdminLog();
        $result = $adminLog->createLog([
            'admin_id' => 1,
            'action_type' => 'LOGIN',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
        ]);
        $this->assertTrue($result);
    }
}
