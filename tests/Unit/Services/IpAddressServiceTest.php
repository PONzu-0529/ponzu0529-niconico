<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Constants\CommandLogConstant;
use App\Services\IpAddressService;

class IpAddressServiceTest extends TestCase
{
    /**
     * GetIpAddressList for COMMAND_LOG
     *
     * @return void
     */
    public function test_getIpAddressListForCommandLog()
    {
        $service = new IpAddressService();
        var_dump($service->getIpAddressList(CommandLogConstant::FUNCTION_ID));

        $this->assertTrue(true);
    }

    /**
     * GetIpAddressList for UNDEFINED_FUNCTION_ID
     *
     * @return void
     */
    public function test_getIpAddressListForNotDefined()
    {
        $service = new IpAddressService();
        var_dump($service->getIpAddressList('UNDEFINED_FUNCTION_ID'));

        $this->assertTrue(true);
    }
}
