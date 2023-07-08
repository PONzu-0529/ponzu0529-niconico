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

        $service->getInstanceStatus(SettingHelper::getSettingValue('SELENIUM_STANDALONE_INSTANCE_ID'));

        $this->assertEquals('', '');
    }

    public function test_fail_aws_start_instance_no_instance_id()
    {
        $service = new AWSService();

        try {
            $service->getInstanceStatus('');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'EC2 Instance ID is Invalid.');
        }
    }

    public function test_fail_aws_start_instance_invalid_instance_id()
    {
        $service = new AWSService();

        try {
            $service->getInstanceStatus('i-dummy');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'EC2 Instance ID is Invalid.');
        }
    }
}
