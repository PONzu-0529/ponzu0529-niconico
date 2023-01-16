<?php

require_once __DIR__ . '/DBBase.php';

require_once __DIR__ . '/../../common/ResponseStyle.php';


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
        ORDER
          BY created_at DESC
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


  public static function check_access_token(string $access_token): ResponseStyle
  {
    $mysqli = DBBase::get_db_connection();

    $sql_result = $mysqli->query(
      "
        SELECT
          `user_account_id`,
          `created_at`
        FROM
          `user_account_access_token`
        WHERE
          `access_token` = '$access_token'
        ORDER
          BY `created_at` DESC
        ;
      "
    );

    $db_result = $sql_result->fetch_all(MYSQLI_ASSOC);

    if (count($db_result) === 0) {
      return new ResponseStyle(
        ResponseStatusOption::FAILURE,
        'This AccessToken is not registered.'
      );
    } else {
      $user_access_token = $db_result[0];

      return new ResponseStyle(
        ResponseStatusOption::SUCCESS,
        new UserAccountAccessTokenStyle(
          -1,
          $user_access_token['user_account_id'],
          $access_token,
          new DateTime($user_access_token['created_at'], new DateTimeZone('Asia/Tokyo')),
          new DateTime('now', new DateTimeZone('Asia/Tokyo'))
        )
      );
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


class UserAccountAccessTokenStyle
{
  private int $id;
  private int $user_account_id;
  private string $access_token;
  private DateTime $created_at;
  private DateTime $updated_at;

  public function __construct(int $id, int $user_account_id, string $access_token, DateTime $created_at, DateTime $updated_at)
  {
    $this->id = $id;
    $this->user_account_id = $user_account_id;
    $this->access_token = $access_token;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }

  public function get_id(): int
  {
    return $this->id;
  }
  public function get_user_account_id(): int
  {
    return $this->user_account_id;
  }
  public function get_access_token(): string
  {
    return $this->access_token;
  }
  public function get_created_at(): DateTime
  {
    return $this->created_at;
  }
  public function get_updated_at(): DateTime
  {
    return $this->updated_at;
  }
}
