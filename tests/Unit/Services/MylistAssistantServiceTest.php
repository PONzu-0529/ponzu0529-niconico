<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\MylistAssistantService;

class MylistAssistantServiceTest extends TestCase
{
    // /**
    //  * Get Niconico Info
    //  *
    //  * @return void
    //  */
    // public function test_getNiconicoInfo()
    // {
    //     $service = new MylistAssistantService();
    //     $result = $service->getNiconicoInfo('sm40663116');
    //     var_dump($result);
    // }

    // /**
    //  * Get NowPlaying Info
    //  *
    //  * @return void
    //  */
    // public function test_getNowPlayingInfo()
    // {
    //     $service = new MylistAssistantService();
    //     $result = $service->getNowPlayingInfo();
    //     var_dump($result);
    // }

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
