<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\MylistAssistantService;

class MylistAssistantServiceTest extends TestCase
{
    /**
     * Check Unique Music ID
     *
     * @return void
     */
    public function test_checkUniqueId()
    {
        $method = new \ReflectionMethod(MylistAssistantService::class, 'checkIdDuplication');
        $method->setAccessible(true);
        $result = $method->invokeArgs(new MylistAssistantService(), ['NiconicoID999']);
        $this->assertFalse($result);
    }

    /**
     * Check Duplicate Music ID
     *
     * @return void
     */
    public function test_checkExistId()
    {
        $method = new \ReflectionMethod(MylistAssistantService::class, 'checkIdDuplication');
        $method->setAccessible(true);
        $result = $method->invokeArgs(new MylistAssistantService(), ['NiconicoID1']);
        $this->assertTrue($result);
    }
}
