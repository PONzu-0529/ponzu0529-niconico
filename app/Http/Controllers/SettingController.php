<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\SettingHelper;
use App\Models\Constants\SettingConstant;

class SettingController extends Controller
{
    /**
     * Get Setting Value
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function show(Request $request)
    {
        return SettingHelper::getSettingValue($request[SettingConstant::KEY]);
    }
}
