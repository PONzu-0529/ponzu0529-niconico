<?php

namespace App\Services;

use App\Constants\IpAddressConstant;
use App\Models\IpAddress;
use App\Models\IpAddressAuthentication;
use App\Models\Constants\IpAddressAuthenticationConstant;

class IpAddressService
{
    /**
     * Get IPAddress List for FunctionID
     *
     * @param string|null $function_id FunctionID
     * @return array IP Address List
     */
    public function getIpAddressList(string $function_id = null): array
    {
        $ip_address_list = [];

        if ($function_id === null) return $ip_address_list;

        $ip_address_id_list = IpAddressAuthentication::where(IpAddressAuthenticationConstant::FUNCTION_ID, $function_id)
            ->get()
            ->toArray();

        foreach ($ip_address_id_list as $ip_address_id) {
            $ip_address = IpAddress::where(IpAddressConstant::ID, $ip_address_id[IpAddressAuthenticationConstant::IP_ADDRESSE_ID])
                ->first()[IpAddressConstant::IP_ADDRESS];

            array_push($ip_address_list, $ip_address);
        }

        return $ip_address_list;
    }
}
