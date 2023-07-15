<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Helpers\SettingHelper;
use App\Services\AWSService;

class AWSTest extends TestCase
{
    public function test_success_start_and_get_ip_address_and_stop_instance()
    {
        $service = new AWSService();

        $instance_id = SettingHelper::getSettingValue('SELENIUM_STANDALONE_INSTANCE_ID');

        // Start
        $service->startInstance($instance_id);

        // Start (2nd)
        $service->startInstance($instance_id);

        // Get IP Address
        $ip_address = $service->getInstanceIPAddress($instance_id);
        var_dump($ip_address);

        // Stop
        $service->stopInstance($instance_id);

        // Stop (2nd)
        $service->stopInstance($instance_id);

        $this->assertTrue(true);
    }
}
