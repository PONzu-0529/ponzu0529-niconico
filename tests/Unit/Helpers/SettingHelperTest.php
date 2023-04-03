<?php

namespace Tests\Unit\Helpers;

use Tests\TestCase;
use App\Helpers\SettingHelper;

class SettingHelperTest extends TestCase
{
    /**
     * Get Setting Value
     *
     * @return void
     */
    public function test_getSettingValue()
    {
        $result = SettingHelper::getSettingValue('ADSENCE_CLIENT_ID');
        $this->assertEquals($result, 'ca-pub-1234567890123456');
    }

    /**
     * Get Setting Undefined Value
     *
     * @return void
     */
    public function test_getSettingUndefinedValue()
    {
        $result = SettingHelper::getSettingValue('UNDEFINED');
        $this->assertEquals($result, '');
    }
}
