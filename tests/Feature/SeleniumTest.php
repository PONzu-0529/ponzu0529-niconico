<?php

namespace Tests\Feature;

use Exception;
use Tests\TestCase;
use App\Helpers\SettingHelper;
use App\Services\AWSService;
use App\Services\SeleniumService;

class SeleniumTest extends TestCase
{
    public function test_success_save_screenshot()
    {
        $aws_service = new AWSService();

        $instance_id = SettingHelper::getSettingValue('SELENIUM_STANDALONE_INSTANCE_ID');

        $aws_service->startInstance($instance_id);

        $ip_address = $aws_service->getInstanceIPAddress($instance_id);

        $selenium_service = new SeleniumService("http://$ip_address:4444");

        try {
            $selenium_service->openPage('https://github.com/PONzu-0529/ponzu0529-tools');

            $selenium_service->saveScreenshot('tests/Feature/screenshot_' . time() . '.png');

            $this->assertTrue(true);
        } catch (Exception $ex) {
            $this->assertTrue(false);
        } finally {
            $selenium_service->quit();

            $aws_service->stopInstance($instance_id);
        }
    }
}
