<?php

namespace App\Helpers;

use App\Models\Setting;
use App\Models\Constants\SettingConstant;

class SettingHelper
{
    /**
     * Get Setting Value
     *
     * @param string $key Key
     * @return string Value
     */
    public static function getSettingValue(string $key): string
    {
        $result = Setting::where([
            SettingConstant::KEY => $key
        ])->first();

        if ($result === NULL) return '';

        return $result[SettingConstant::VALUE];
    }
}
