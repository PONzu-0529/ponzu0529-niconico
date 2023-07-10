<?php

namespace Tests\Unit\Services;

use Exception;
use Tests\TestCase;
use App\Helpers\SettingHelper;
use App\Services\AWSService;

class AWSServiceTest extends TestCase
{
    public function test_succcess_aws_start_instance()
    {
        $service = new AWSService();

        $service->isInstanceRunning(SettingHelper::getSettingValue('SELENIUM_STANDALONE_INSTANCE_ID'));

        $this->assertTrue(true);
    }

    public function test_fail_aws_start_instance_no_instance_id()
    {
        $service = new AWSService();

        try {
            $service->isInstanceRunning('');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'EC2 Instance ID is Invalid.');
        }
    }

    public function test_fail_aws_start_instance_invalid_instance_id()
    {
        $service = new AWSService();

        try {
            $service->isInstanceRunning('i-dummy');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'EC2 Instance ID is Invalid.');
        }
    }

    public function test_success_aws_start_and_stop_instance()
    {
        $service = new AWSService();

        try {
            $service->getInstanceIPAddress(SettingHelper::getSettingValue('SELENIUM_STANDALONE_INSTANCE_ID'));
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'This Instance is not Started.');
        }

        $service->startInstance(SettingHelper::getSettingValue('SELENIUM_STANDALONE_INSTANCE_ID'));

        try {
            $service->startInstance(SettingHelper::getSettingValue('SELENIUM_STANDALONE_INSTANCE_ID'));
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'This Instance is Already Started.');
        }

        $service->getInstanceIPAddress(SettingHelper::getSettingValue('SELENIUM_STANDALONE_INSTANCE_ID'));

        $service->stopInstance(SettingHelper::getSettingValue('SELENIUM_STANDALONE_INSTANCE_ID'));

        try {
            $service->stopInstance(SettingHelper::getSettingValue('SELENIUM_STANDALONE_INSTANCE_ID'));
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'This Instance is Already Stopped.');
        }

        $this->assertTrue(true);
    }
}
