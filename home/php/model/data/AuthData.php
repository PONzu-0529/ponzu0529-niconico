<?php

require_once __DIR__ . '/../db/UserAccounts.php';
require_once __DIR__ . '/../db/UserAccountAccessToken.php';


class AuthData
{
  private UserAccounts $user_accounts;
  private UserAccountAccessToken $user_account_access_token;


  public function __construct()
  {
    $this->user_accounts = new UserAccounts();
    $this->user_account_access_token = new UserAccountAccessToken();
  }
}
