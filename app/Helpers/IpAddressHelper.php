<?php

namespace App\Helpers;

use App\Services\IpAddressService;

class IpAddressHelper
{
  /**
   * Check IP Address
   *
   * @param string $function_id FunctionID
   * @param string $ip IP Address
   * @return boolean
   */
  public static function checkIpAddress(string $function_id, string $ip): bool
  {
    $service = new IpAddressService();

    $ip_address_list = $service->getIpAddressList($function_id);

    return in_array($ip, $ip_address_list);
  }
}
