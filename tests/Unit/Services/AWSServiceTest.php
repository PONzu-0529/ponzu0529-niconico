<?php

namespace Tests\Unit\Services;

use Exception;
use Tests\TestCase;
use App\Helpers\SettingHelper;
use App\Services\AWSService;

class AWSServiceTest extends TestCase
{
    public function test_fail_is_instance_state_no_instance_id()
    {
        $service = new AWSService();

        try {
            $service->isInstanceState('');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'EC2 Instance ID is Invalid.');
        }
    }

    public function test_fail_is_instance_state_invalid_instance_id()
    {
        $service = new AWSService();

        try {
            $service->isInstanceState('i-dummy');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'EC2 Instance ID is Invalid.');
        }
    }

    public function test_fail_start_instance_no_instance_id()
    {
        $service = new AWSService();

        try {
            $service->startInstance('');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'EC2 Instance ID is Invalid.');
        }
    }

    public function test_fail_start_instance_invalid_instance_id()
    {
        $service = new AWSService();

        try {
            $service->startInstance('i-duumy');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'EC2 Instance ID is Invalid.');
        }
    }

    public function test_fail_stop_instance_no_instance_id()
    {
        $service = new AWSService();

        try {
            $service->stopInstance('');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'EC2 Instance ID is Invalid.');
        }
    }

    public function test_fail_stop_instance_invalid_instance_id()
    {
        $service = new AWSService();

        try {
            $service->stopInstance('i-duumy');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'EC2 Instance ID is Invalid.');
        }
    }

    public function test_fail_get_instance_ip_address_no_instance_id()
    {
        $service = new AWSService();

        try {
            $service->getInstanceIPAddress('');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'EC2 Instance ID is Invalid.');
        }
    }

    public function test_fail_get_instance_ip_address_invalid_instance_id()
    {
        $service = new AWSService();

        try {
            $service->getInstanceIPAddress('i-duumy');
        } catch (Exception $ex) {
            $this->assertEquals($ex->getMessage(), 'EC2 Instance ID is Invalid.');
        }
    }
}
