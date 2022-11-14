<?php

require_once __DIR__ . '/ApiTestBase.php';

require_once __DIR__ . '/../../common/ResponseStyle.php';


class AuthApiTest
{
  private const SERVICE_NAME = 'AuthApiTest';


  public static function GetAccessTokenByEmail(): ResponseStyle
  {
    $host = ApiTestBase::get_host();

    return ApiTestBase::CommonPostApiTest(
      static::SERVICE_NAME,
      "$host/api/v2/auth/get-access-token-by-email",
      [
        'email' => 'test@tools.ponzu0529.com',
        'password' => 'test_password'
      ]
    );
  }


  public static function CheckAccessToken(): ResponseStyle
  {
    $host = ApiTestBase::get_host();

    return ApiTestBase::CommonPostApiTest(
      static::SERVICE_NAME,
      "$host/api/v2/auth/check-access-token",
      [
        'accessToken' => 'test_access_token'
      ]
    );
  }


  public static function CheckAccessTokenByEmail(): ResponseStyle
  {
    $host = ApiTestBase::get_host();

    return ApiTestBase::CommonPostApiTest(
      static::SERVICE_NAME,
      "$host/api/v2/auth/check-access-token-by-email",
      [
        'email' => 'access_token_test@tools.ponzu0529.com',
        'accessToken' => 'test_access_token'
      ]
    );
  }
}
