<?php

namespace App\Helpers;

class IpAddressHelper
{
  public static function checkIpAddress(string $ip): void
  {
    if ($ip !== env('ACCEPT_IP_ADDRESS', '127.0.0.1')) {
      abort(403, 'This IP Address is unauthorized.');
    }
  }
}
