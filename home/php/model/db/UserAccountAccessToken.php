<?php

require_once __DIR__ . '/DBBase.php';


class UserAccountAccessToken extends DBBase
{
  public function get_access_token_by_user_account_id(int $id): string
  {
    $sql_result = $this->mysqli->query(
      "
        SELECT
          `access_token`
        FROM
          `user_account_access_token`
        WHERE
          `user_account_id` = '$id'
          AND created_at > (now() - INTERVAL 1 DAY)
        ;
      "
    );

    $db_result = $sql_result->fetch_assoc();

    if (isset($db_result)) {
      return $db_result["access_token"];
    } else {
      return '';
    }
  }


  public function insert_access_token(int $user_account_id, string $access_token): void
  {
    $this->mysqli->query(
      "
        INSERT INTO `user_account_access_token`
          (`user_account_id`, `access_token`, `created_at`, `updated_at`)
        VALUES
          ('$user_account_id', '$access_token', now(), now())
        ;
      "
    );
  }
}
